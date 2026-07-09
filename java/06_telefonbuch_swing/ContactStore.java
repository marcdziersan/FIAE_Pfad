import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;

public class ContactStore {
    private final Path file = Path.of("contacts.tsv");

    public List<Contact> load() {
        List<Contact> contacts = new ArrayList<>();
        if (!Files.exists(file)) return contacts;
        try (BufferedReader reader = Files.newBufferedReader(file)) {
            String line;
            while ((line = reader.readLine()) != null) {
                if (!line.isBlank()) contacts.add(Contact.fromLine(line));
            }
        } catch (Exception ex) {
            System.err.println("Kontakte konnten nicht geladen werden: " + ex.getMessage());
        }
        return contacts;
    }

    public void save(List<Contact> contacts) {
        try (BufferedWriter writer = Files.newBufferedWriter(file)) {
            for (Contact contact : contacts) {
                writer.write(contact.toLine());
                writer.newLine();
            }
        } catch (IOException ex) {
            throw new RuntimeException("Kontakte konnten nicht gespeichert werden", ex);
        }
    }

    public int nextId(List<Contact> contacts) {
        int max = 0;
        for (Contact contact : contacts) if (contact.getId() > max) max = contact.getId();
        return max + 1;
    }
}
