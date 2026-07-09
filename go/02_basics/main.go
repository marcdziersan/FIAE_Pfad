package main

import "fmt"

type Note struct {
    ID      int
    Title   string
    Done    bool
}

func markDone(note Note) Note {
    note.Done = true
    return note
}

func main() {
    name := "Marcus"
    year := 2026
    notes := []Note{
        {ID: 1, Title: "Variablen verstehen"},
        {ID: 2, Title: "Structs nutzen"},
    }

    notes[0] = markDone(notes[0])

    fmt.Printf("Lernender: %s · Jahr: %d\n", name, year)
    for _, note := range notes {
        status := "offen"
        if note.Done {
            status = "erledigt"
        }
        fmt.Printf("#%d %s [%s]\n", note.ID, note.Title, status)
    }
}
