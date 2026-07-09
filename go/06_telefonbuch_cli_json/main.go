package main

import (
	"encoding/json"
	"fmt"
	"os"
	"strconv"
	"strings"
)

type Contact struct {
	ID    int    `json:"id"`
	Name  string `json:"name"`
	Phone string `json:"phone"`
	Email string `json:"email"`
}

const fileName = "contacts.json"

func loadContacts() ([]Contact, error) {
	data, err := os.ReadFile(fileName)
	if os.IsNotExist(err) {
		return []Contact{}, nil
	}
	if err != nil {
		return nil, err
	}
	if len(data) == 0 {
		return []Contact{}, nil
	}
	var contacts []Contact
	if err := json.Unmarshal(data, &contacts); err != nil {
		return nil, err
	}
	return contacts, nil
}

func saveContacts(contacts []Contact) error {
	data, err := json.MarshalIndent(contacts, "", "  ")
	if err != nil {
		return err
	}
	return os.WriteFile(fileName, data, 0644)
}

func nextID(contacts []Contact) int {
	maxID := 0
	for _, c := range contacts {
		if c.ID > maxID {
			maxID = c.ID
		}
	}
	return maxID + 1
}

func printContacts(contacts []Contact) {
	if len(contacts) == 0 {
		fmt.Println("Keine Kontakte vorhanden.")
		return
	}
	for _, c := range contacts {
		fmt.Printf("%d | %s | %s | %s\n", c.ID, c.Name, c.Phone, c.Email)
	}
}

func usage() {
	fmt.Println("Nutzung:")
	fmt.Println("  go run . add <name> <telefon> <email>")
	fmt.Println("  go run . list")
	fmt.Println("  go run . search <begriff>")
	fmt.Println("  go run . delete <id>")
}

func main() {
	if len(os.Args) < 2 {
		usage()
		return
	}
	contacts, err := loadContacts()
	if err != nil {
		fmt.Println("Fehler beim Laden:", err)
		os.Exit(1)
	}

	switch os.Args[1] {
	case "add":
		if len(os.Args) != 5 {
			usage(); return
		}
		contacts = append(contacts, Contact{ID: nextID(contacts), Name: os.Args[2], Phone: os.Args[3], Email: os.Args[4]})
		if err := saveContacts(contacts); err != nil { fmt.Println(err); os.Exit(1) }
		fmt.Println("Kontakt gespeichert.")
	case "list":
		printContacts(contacts)
	case "search":
		if len(os.Args) != 3 { usage(); return }
		term := strings.ToLower(os.Args[2])
		var hits []Contact
		for _, c := range contacts {
			text := strings.ToLower(c.Name + " " + c.Phone + " " + c.Email)
			if strings.Contains(text, term) { hits = append(hits, c) }
		}
		printContacts(hits)
	case "delete":
		if len(os.Args) != 3 { usage(); return }
		id, err := strconv.Atoi(os.Args[2])
		if err != nil { fmt.Println("Ungültige ID"); return }
		var kept []Contact
		for _, c := range contacts { if c.ID != id { kept = append(kept, c) } }
		if err := saveContacts(kept); err != nil { fmt.Println(err); os.Exit(1) }
		fmt.Println("Kontakt gelöscht, falls ID vorhanden war.")
	default:
		usage()
	}
}
