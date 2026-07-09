public class Contact {
    private final int id;
    private String name;
    private String phone;
    private String email;

    public Contact(int id, String name, String phone, String email) {
        this.id = id;
        this.name = name;
        this.phone = phone;
        this.email = email;
    }

    public int getId() { return id; }
    public String getName() { return name; }
    public String getPhone() { return phone; }
    public String getEmail() { return email; }
    public void setName(String name) { this.name = name; }
    public void setPhone(String phone) { this.phone = phone; }
    public void setEmail(String email) { this.email = email; }

    public String toLine() {
        return id + "\t" + safe(name) + "\t" + safe(phone) + "\t" + safe(email);
    }

    public static Contact fromLine(String line) {
        String[] parts = line.split("\t", -1);
        return new Contact(Integer.parseInt(parts[0]), restore(parts[1]), restore(parts[2]), restore(parts[3]));
    }

    private static String safe(String value) { return value.replace("\t", " ").replace("\n", " "); }
    private static String restore(String value) { return value; }
}
