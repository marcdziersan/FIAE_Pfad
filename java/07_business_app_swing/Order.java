public class Order {
    private final int id;
    private String customer;
    private String title;
    private double net;
    private String status;

    public Order(int id, String customer, String title, double net, String status) {
        this.id = id;
        this.customer = customer;
        this.title = title;
        this.net = net;
        this.status = status;
    }

    public int getId() { return id; }
    public String getCustomer() { return customer; }
    public String getTitle() { return title; }
    public double getNet() { return net; }
    public double getVat() { return net * 0.19; }
    public double getGross() { return net * 1.19; }
    public String getStatus() { return status; }
    public void setCustomer(String customer) { this.customer = customer; }
    public void setTitle(String title) { this.title = title; }
    public void setNet(double net) { this.net = net; }
    public void setStatus(String status) { this.status = status; }

    public String toLine() {
        return id + "\t" + safe(customer) + "\t" + safe(title) + "\t" + net + "\t" + safe(status);
    }

    public static Order fromLine(String line) {
        String[] p = line.split("\t", -1);
        return new Order(Integer.parseInt(p[0]), p[1], p[2], Double.parseDouble(p[3]), p[4]);
    }

    private static String safe(String value) { return value.replace("\t", " ").replace("\n", " "); }
}
