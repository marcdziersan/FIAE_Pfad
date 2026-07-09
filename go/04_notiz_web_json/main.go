package main

import (
    "encoding/json"
    "fmt"
    "html/template"
    "log"
    "net/http"
    "os"
    "strconv"
    "strings"
    "time"
)

type Note struct {
    ID        int       `json:"id"`
    Title     string    `json:"title"`
    Content   string    `json:"content"`
    Done      bool      `json:"done"`
    CreatedAt time.Time `json:"created_at"`
}

type PageData struct {
    Notes []Note
    Error string
}

const fileName = "notes.json"

var page = template.Must(template.New("page").Parse(`<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Go Notiz-Web-App</title>
<style>
*{box-sizing:border-box}body{margin:0;padding:1rem;font-family:system-ui,sans-serif;background:#f8fafc;color:#0f172a}.layout{width:min(100%,820px);margin:0 auto;display:grid;gap:1rem}.panel,.note{border:1px solid #cbd5e1;border-radius:1rem;background:white;padding:1rem}.kicker{color:#059669;font-weight:800}.form{display:grid;gap:.65rem}input,textarea,button{font:inherit}input,textarea{border:1px solid #cbd5e1;border-radius:.75rem;padding:.8rem}button{border:0;border-radius:.75rem;padding:.75rem 1rem;background:#059669;color:white;font-weight:800;cursor:pointer}.danger{background:#dc2626}.secondary{background:#2563eb}.notes{display:grid;gap:.75rem}.note{display:flex;justify-content:space-between;gap:1rem}.note.done{opacity:.65}.note.done h3{text-decoration:line-through}.actions{display:flex;gap:.5rem}.error{color:#b91c1c}@media(max-width:600px){.note,.actions{flex-direction:column}.actions form,.actions button{width:100%}}
</style>
</head>
<body>
<main class="layout">
  <header class="panel">
    <p class="kicker">FIAE Grundlagen · Go net/http JSON CRUD</p>
    <h1>Go Notiz-Web-App</h1>
    <p>Kleines CRUD-Beispiel mit Standardbibliothek, Templates und JSON-Datei.</p>
  </header>
  <section class="panel">
    <h2>Neue Notiz</h2>
    {{if .Error}}<p class="error">{{.Error}}</p>{{end}}
    <form class="form" method="post" action="/add">
      <label for="title">Titel</label>
      <input id="title" name="title" required maxlength="80">
      <label for="content">Inhalt</label>
      <textarea id="content" name="content" required maxlength="400" rows="4"></textarea>
      <button type="submit">Speichern</button>
    </form>
  </section>
  <section class="panel">
    <h2>Notizen</h2>
    <div class="notes">
      {{range .Notes}}
        <article class="note {{if .Done}}done{{end}}">
          <div>
            <h3>{{.Title}}</h3>
            <p>{{.Content}}</p>
            <small>{{.CreatedAt.Format "02.01.2006 15:04"}}</small>
          </div>
          <div class="actions">
            <form method="post" action="/toggle"><input type="hidden" name="id" value="{{.ID}}"><button class="secondary" type="submit">Status</button></form>
            <form method="post" action="/delete"><input type="hidden" name="id" value="{{.ID}}"><button class="danger" type="submit">Löschen</button></form>
          </div>
        </article>
      {{else}}
        <p>Noch keine Notizen vorhanden.</p>
      {{end}}
    </div>
  </section>
</main>
</body>
</html>`))

func main() {
    http.HandleFunc("/", handleIndex)
    http.HandleFunc("/add", handleAdd)
    http.HandleFunc("/toggle", handleToggle)
    http.HandleFunc("/delete", handleDelete)

    fmt.Println("Server läuft auf http://localhost:8080")
    log.Fatal(http.ListenAndServe(":8080", nil))
}

func handleIndex(w http.ResponseWriter, r *http.Request) {
    notes, err := loadNotes()
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    page.Execute(w, PageData{Notes: notes})
}

func handleAdd(w http.ResponseWriter, r *http.Request) {
    if r.Method != http.MethodPost {
        http.Redirect(w, r, "/", http.StatusSeeOther)
        return
    }
    title := strings.TrimSpace(r.FormValue("title"))
    content := strings.TrimSpace(r.FormValue("content"))
    if len(title) < 3 || len(content) < 3 {
        notes, _ := loadNotes()
        page.Execute(w, PageData{Notes: notes, Error: "Titel und Inhalt müssen mindestens 3 Zeichen haben."})
        return
    }
    notes, err := loadNotes()
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    notes = append(notes, Note{ID: nextID(notes), Title: title, Content: content, CreatedAt: time.Now()})
    if err := saveNotes(notes); err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    http.Redirect(w, r, "/", http.StatusSeeOther)
}

func handleToggle(w http.ResponseWriter, r *http.Request) {
    updateByID(w, r, func(note *Note) { note.Done = !note.Done })
}

func handleDelete(w http.ResponseWriter, r *http.Request) {
    id, err := strconv.Atoi(r.FormValue("id"))
    if err != nil {
        http.Redirect(w, r, "/", http.StatusSeeOther)
        return
    }
    notes, err := loadNotes()
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    filtered := make([]Note, 0, len(notes))
    for _, note := range notes {
        if note.ID != id {
            filtered = append(filtered, note)
        }
    }
    if err := saveNotes(filtered); err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    http.Redirect(w, r, "/", http.StatusSeeOther)
}

func updateByID(w http.ResponseWriter, r *http.Request, update func(*Note)) {
    id, err := strconv.Atoi(r.FormValue("id"))
    if err != nil {
        http.Redirect(w, r, "/", http.StatusSeeOther)
        return
    }
    notes, err := loadNotes()
    if err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    for i := range notes {
        if notes[i].ID == id {
            update(&notes[i])
        }
    }
    if err := saveNotes(notes); err != nil {
        http.Error(w, err.Error(), http.StatusInternalServerError)
        return
    }
    http.Redirect(w, r, "/", http.StatusSeeOther)
}

func loadNotes() ([]Note, error) {
    data, err := os.ReadFile(fileName)
    if os.IsNotExist(err) {
        return []Note{}, nil
    }
    if err != nil {
        return nil, err
    }
    if len(data) == 0 {
        return []Note{}, nil
    }
    var notes []Note
    return notes, json.Unmarshal(data, &notes)
}

func saveNotes(notes []Note) error {
    data, err := json.MarshalIndent(notes, "", "  ")
    if err != nil {
        return err
    }
    return os.WriteFile(fileName, data, 0644)
}

func nextID(notes []Note) int {
    maxID := 0
    for _, note := range notes {
        if note.ID > maxID {
            maxID = note.ID
        }
    }
    return maxID + 1
}
