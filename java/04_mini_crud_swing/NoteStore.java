import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;

public class NoteStore {
    private final Path filePath = Path.of("notes.txt");

    public List<Note> load() throws IOException {
        if (!Files.exists(filePath)) {
            return new ArrayList<>();
        }
        List<Note> notes = new ArrayList<>();
        for (String line : Files.readAllLines(filePath, StandardCharsets.UTF_8)) {
            if (!line.isBlank()) {
                notes.add(Note.fromFileLine(line));
            }
        }
        return notes;
    }

    public void save(List<Note> notes) throws IOException {
        List<String> lines = new ArrayList<>();
        for (Note note : notes) {
            lines.add(note.toFileLine());
        }
        Files.write(filePath, lines, StandardCharsets.UTF_8);
    }

    public int nextId(List<Note> notes) {
        int max = 0;
        for (Note note : notes) {
            max = Math.max(max, note.getId());
        }
        return max + 1;
    }
}
