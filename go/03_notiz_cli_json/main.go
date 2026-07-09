package main

import (
    "encoding/json"
    "errors"
    "fmt"
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

const fileName = "notes.json"

func main() {
    if len(os.Args) < 2 {
        printHelp()
        return
    }

    command := os.Args[1]

    switch command {
    case "add":
        must(addNote(os.Args[2:]))
    case "list":
        must(listNotes())
    case "done":
        must(updateDone(os.Args[2:], true))
    case "open":
        must(updateDone(os.Args[2:], false))
    case "delete":
        must(deleteNote(os.Args[2:]))
    default:
        printHelp()
    }
}

func printHelp() {
    fmt.Println("Notiz CLI")
    fmt.Println("Befehle:")
    fmt.Println("  go run . add \"Titel\" \"Inhalt\"")
    fmt.Println("  go run . list")
    fmt.Println("  go run . done 1")
    fmt.Println("  go run . open 1")
    fmt.Println("  go run . delete 1")
}

func addNote(args []string) error {
    if len(args) < 2 {
        return errors.New("add benötigt Titel und Inhalt")
    }
    title := strings.TrimSpace(args[0])
    content := strings.TrimSpace(args[1])
    if len(title) < 3 || len(content) < 3 {
        return errors.New("Titel und Inhalt müssen mindestens 3 Zeichen haben")
    }

    notes, err := loadNotes()
    if err != nil {
        return err
    }
    notes = append(notes, Note{
        ID: nextID(notes),
        Title: title,
        Content: content,
        CreatedAt: time.Now(),
    })
    if err := saveNotes(notes); err != nil {
        return err
    }
    fmt.Println("Notiz gespeichert.")
    return nil
}

func listNotes() error {
    notes, err := loadNotes()
    if err != nil {
        return err
    }
    if len(notes) == 0 {
        fmt.Println("Keine Notizen vorhanden.")
        return nil
    }
    for _, note := range notes {
        status := "offen"
        if note.Done {
            status = "erledigt"
        }
        fmt.Printf("#%d [%s] %s - %s\n", note.ID, status, note.Title, note.Content)
    }
    return nil
}

func updateDone(args []string, done bool) error {
    id, err := parseID(args)
    if err != nil {
        return err
    }
    notes, err := loadNotes()
    if err != nil {
        return err
    }
    found := false
    for i := range notes {
        if notes[i].ID == id {
            notes[i].Done = done
            found = true
        }
    }
    if !found {
        return fmt.Errorf("keine Notiz mit ID %d gefunden", id)
    }
    return saveNotes(notes)
}

func deleteNote(args []string) error {
    id, err := parseID(args)
    if err != nil {
        return err
    }
    notes, err := loadNotes()
    if err != nil {
        return err
    }
    filtered := make([]Note, 0, len(notes))
    for _, note := range notes {
        if note.ID != id {
            filtered = append(filtered, note)
        }
    }
    if len(filtered) == len(notes) {
        return fmt.Errorf("keine Notiz mit ID %d gefunden", id)
    }
    return saveNotes(filtered)
}

func loadNotes() ([]Note, error) {
    data, err := os.ReadFile(fileName)
    if errors.Is(err, os.ErrNotExist) {
        return []Note{}, nil
    }
    if err != nil {
        return nil, err
    }
    if len(data) == 0 {
        return []Note{}, nil
    }
    var notes []Note
    if err := json.Unmarshal(data, &notes); err != nil {
        return nil, err
    }
    return notes, nil
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

func parseID(args []string) (int, error) {
    if len(args) < 1 {
        return 0, errors.New("ID fehlt")
    }
    return strconv.Atoi(args[0])
}

func must(err error) {
    if err != nil {
        fmt.Fprintln(os.Stderr, "Fehler:", err)
        os.Exit(1)
    }
}
