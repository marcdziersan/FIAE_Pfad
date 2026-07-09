package main

import (
	"encoding/json"
	"fmt"
	"html/template"
	"log"
	"net/http"
	"os"
	"strconv"
	"time"
)

type Order struct {
	ID        int     `json:"id"`
	Customer  string  `json:"customer"`
	Title     string  `json:"title"`
	Net       float64 `json:"net"`
	VAT       float64 `json:"vat"`
	Gross     float64 `json:"gross"`
	Status    string  `json:"status"`
	CreatedAt string  `json:"created_at"`
}

type PageData struct {
	Orders []Order
	Net    float64
	VAT    float64
	Gross  float64
	Error  string
}

const fileName = "orders.json"

var statuses = map[string]bool{"offen": true, "in Arbeit": true, "erledigt": true, "abgerechnet": true}

func loadOrders() ([]Order, error) {
	data, err := os.ReadFile(fileName)
	if os.IsNotExist(err) { return []Order{}, nil }
	if err != nil { return nil, err }
	if len(data) == 0 { return []Order{}, nil }
	var orders []Order
	if err := json.Unmarshal(data, &orders); err != nil { return nil, err }
	return orders, nil
}

func saveOrders(orders []Order) error {
	data, err := json.MarshalIndent(orders, "", "  ")
	if err != nil { return err }
	return os.WriteFile(fileName, data, 0644)
}

func nextID(orders []Order) int {
	maxID := 0
	for _, o := range orders { if o.ID > maxID { maxID = o.ID } }
	return maxID + 1
}

func totals(orders []Order) (float64, float64, float64) {
	var net, vat, gross float64
	for _, o := range orders { net += o.Net; vat += o.VAT; gross += o.Gross }
	return net, vat, gross
}

func render(w http.ResponseWriter, errorText string) {
	orders, err := loadOrders()
	if err != nil { http.Error(w, err.Error(), 500); return }
	net, vat, gross := totals(orders)
	tpl := template.Must(template.New("page").Funcs(template.FuncMap{"euro": func(v float64) string { return fmt.Sprintf("%.2f €", v) }}).Parse(pageHTML))
	_ = tpl.Execute(w, PageData{Orders: orders, Net: net, VAT: vat, Gross: gross, Error: errorText})
}

func indexHandler(w http.ResponseWriter, r *http.Request) { render(w, "") }

func createHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost { http.Redirect(w, r, "/", http.StatusSeeOther); return }
	orders, err := loadOrders()
	if err != nil { http.Error(w, err.Error(), 500); return }
	customer := r.FormValue("customer")
	title := r.FormValue("title")
	net, err := strconv.ParseFloat(r.FormValue("net"), 64)
	status := r.FormValue("status")
	if customer == "" || title == "" || err != nil || net < 0 {
		render(w, "Bitte Kunde, Auftrag und gültigen Nettobetrag eingeben."); return
	}
	if !statuses[status] { status = "offen" }
	orders = append(orders, Order{ID: nextID(orders), Customer: customer, Title: title, Net: net, VAT: net * 0.19, Gross: net * 1.19, Status: status, CreatedAt: time.Now().Format("2006-01-02 15:04")})
	if err := saveOrders(orders); err != nil { http.Error(w, err.Error(), 500); return }
	http.Redirect(w, r, "/", http.StatusSeeOther)
}

func statusHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost { http.Redirect(w, r, "/", http.StatusSeeOther); return }
	orders, _ := loadOrders()
	id, _ := strconv.Atoi(r.FormValue("id"))
	status := r.FormValue("status")
	if !statuses[status] { status = "offen" }
	for i := range orders { if orders[i].ID == id { orders[i].Status = status } }
	_ = saveOrders(orders)
	http.Redirect(w, r, "/", http.StatusSeeOther)
}

func deleteHandler(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost { http.Redirect(w, r, "/", http.StatusSeeOther); return }
	orders, _ := loadOrders()
	id, _ := strconv.Atoi(r.FormValue("id"))
	kept := make([]Order, 0, len(orders))
	for _, o := range orders { if o.ID != id { kept = append(kept, o) } }
	_ = saveOrders(kept)
	http.Redirect(w, r, "/", http.StatusSeeOther)
}

func main() {
	http.HandleFunc("/", indexHandler)
	http.HandleFunc("/create", createHandler)
	http.HandleFunc("/status", statusHandler)
	http.HandleFunc("/delete", deleteHandler)
	fmt.Println("Server läuft: http://localhost:8081")
	log.Fatal(http.ListenAndServe(":8081", nil))
}

const pageHTML = `<!doctype html>
<html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Go Business App</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#101827;color:#f8fafc;padding:1rem}.app{width:min(100%,1100px);margin:auto}.panel,.summary div,.error{background:#172033;border:1px solid #334155;border-radius:16px;padding:1rem;margin:1rem 0}.summary{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}.summary strong{display:block;color:#86efac;font-size:1.5rem}.grid{display:grid;grid-template-columns:repeat(5,1fr);gap:.7rem;align-items:end}label{display:grid;gap:.3rem}input,select,button{min-height:40px;border-radius:9px;border:1px solid #475569;padding:.6rem;font:inherit}input,select{background:#0f172a;color:#fff}button{background:#38bdf8;border:0;font-weight:800}.danger{background:#ef4444;color:#fff}.row{display:grid;grid-template-columns:1fr 1.5fr .8fr .8fr 1fr auto;gap:.6rem;align-items:center;background:#0f172a;border-radius:12px;padding:.7rem;margin:.4rem 0}.head{font-weight:800;background:#243047}.error{border-color:#ef4444;color:#fecaca}@media(max-width:850px){.summary,.grid,.row{grid-template-columns:1fr}.head{display:none}}
</style></head><body><main class="app"><p>07 · Go</p><h1>Mini-Auftragsverwaltung</h1><p>Business-Grundlage mit JSON-Speicher und net/http.</p>{{if .Error}}<div class="error">{{.Error}}</div>{{end}}<section class="summary"><div><strong>{{euro .Net}}</strong><span>Netto</span></div><div><strong>{{euro .VAT}}</strong><span>MwSt.</span></div><div><strong>{{euro .Gross}}</strong><span>Brutto</span></div></section><section class="panel"><h2>Auftrag erfassen</h2><form class="grid" method="post" action="/create"><label>Kunde<input name="customer" required></label><label>Auftrag<input name="title" required></label><label>Netto<input name="net" type="number" step="0.01" min="0" required></label><label>Status<select name="status"><option>offen</option><option>in Arbeit</option><option>erledigt</option><option>abgerechnet</option></select></label><button>Speichern</button></form></section><section class="panel"><h2>Aufträge</h2><div class="row head"><span>Kunde</span><span>Auftrag</span><span>Netto</span><span>Brutto</span><span>Status</span><span>Aktion</span></div>{{range .Orders}}<div class="row"><span>{{.Customer}}</span><span>{{.Title}}</span><span>{{euro .Net}}</span><span>{{euro .Gross}}</span><form method="post" action="/status"><input type="hidden" name="id" value="{{.ID}}"><select name="status" onchange="this.form.submit()"><option>{{.Status}}</option><option>offen</option><option>in Arbeit</option><option>erledigt</option><option>abgerechnet</option></select></form><form method="post" action="/delete"><input type="hidden" name="id" value="{{.ID}}"><button class="danger">Löschen</button></form></div>{{end}}</section></main></body></html>`
