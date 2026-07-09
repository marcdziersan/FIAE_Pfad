package main

import (
	"errors"
	"fmt"
	"os"
	"strconv"
)

func calculate(a float64, op string, b float64) (float64, error) {
	switch op {
	case "+":
		return a + b, nil
	case "-":
		return a - b, nil
	case "*", "x":
		return a * b, nil
	case "/":
		if b == 0 {
			return 0, errors.New("Division durch 0 ist nicht erlaubt")
		}
		return a / b, nil
	default:
		return 0, fmt.Errorf("unbekannter Operator: %s", op)
	}
}

func main() {
	if len(os.Args) != 4 {
		fmt.Println("Nutzung: go run . <zahlA> <operator> <zahlB>")
		fmt.Println("Beispiel: go run . 12 + 5")
		os.Exit(1)
	}

	a, err := strconv.ParseFloat(os.Args[1], 64)
	if err != nil {
		fmt.Println("Zahl A ist ungültig")
		os.Exit(1)
	}
	b, err := strconv.ParseFloat(os.Args[3], 64)
	if err != nil {
		fmt.Println("Zahl B ist ungültig")
		os.Exit(1)
	}

	result, err := calculate(a, os.Args[2], b)
	if err != nil {
		fmt.Println("Fehler:", err)
		os.Exit(1)
	}

	fmt.Printf("%.2f %s %.2f = %.2f\n", a, os.Args[2], b, result)
}
