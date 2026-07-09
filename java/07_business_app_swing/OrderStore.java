import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;

public class OrderStore {
    private final Path file = Path.of("orders.tsv");

    public List<Order> load() {
        List<Order> orders = new ArrayList<>();
        if (!Files.exists(file)) return orders;
        try (BufferedReader reader = Files.newBufferedReader(file)) {
            String line;
            while ((line = reader.readLine()) != null) {
                if (!line.isBlank()) orders.add(Order.fromLine(line));
            }
        } catch (Exception ex) {
            System.err.println("Aufträge konnten nicht geladen werden: " + ex.getMessage());
        }
        return orders;
    }

    public void save(List<Order> orders) {
        try (BufferedWriter writer = Files.newBufferedWriter(file)) {
            for (Order order : orders) {
                writer.write(order.toLine());
                writer.newLine();
            }
        } catch (IOException ex) {
            throw new RuntimeException("Aufträge konnten nicht gespeichert werden", ex);
        }
    }

    public int nextId(List<Order> orders) {
        int max = 0;
        for (Order order : orders) if (order.getId() > max) max = order.getId();
        return max + 1;
    }
}
