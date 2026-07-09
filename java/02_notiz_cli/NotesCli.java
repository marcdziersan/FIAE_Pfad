import java.util.ArrayList;
import java.util.List;

public class NotesCli {
    private static final NoteStore STORE = new NoteStore("notes.txt");

    public static void main(String[] args) throws Exception {
        if (args.length == 0) {
            printHelp();
            return;
        }

        switch (args[0]) {
            case "add" -> add(args);
            case "list" -> list();
            case "done" -> setDone(args, true);
            case "open" -> setDone(args, false);
            case "delete" -> delete(args);
            default -> printHelp();
        }
    }

    private static void printHelp() {
        System.out.println("Notiz CLI");
        System.out.println("java NotesCli add \"Titel\" \"Inhalt\"");
        System.out.println("java NotesCli list");
        System.out.println("java NotesCli done 1");
        System.out.println("java NotesCli open 1");
        System.out.println("java NotesCli delete 1");
    }

    private static void add(String[] args) throws Exception {
        if (args.length < 3) {
            throw new IllegalArgumentException("add benötigt Titel und Inhalt");
        }
        String title = args[1].trim();
        String content = args[2].trim();
        if (title.length() < 3 || content.length() < 3) {
            throw new IllegalArgumentException("Titel und Inhalt müssen mindestens 3 Zeichen haben");
        }
        List<Note> notes = STORE.load();
        notes.add(new Note(STORE.nextId(notes), title, content, false));
        STORE.save(notes);
        System.out.println("Notiz gespeichert.");
    }

    private static void list() throws Exception {
        List<Note> notes = STORE.load();
        if (notes.isEmpty()) {
            System.out.println("Keine Notizen vorhanden.");
            return;
        }
        for (Note note : notes) {
            String status = note.isDone() ? "erledigt" : "offen";
            System.out.printf("#%d [%s] %s - %s%n", note.getId(), status, note.getTitle(), note.getContent());
        }
    }

    private static void setDone(String[] args, boolean done) throws Exception {
        int id = parseId(args);
        List<Note> updated = new ArrayList<>();
        for (Note note : STORE.load()) {
            updated.add(note.getId() == id ? note.withDone(done) : note);
        }
        STORE.save(updated);
    }

    private static void delete(String[] args) throws Exception {
        int id = parseId(args);
        List<Note> updated = new ArrayList<>();
        for (Note note : STORE.load()) {
            if (note.getId() != id) {
                updated.add(note);
            }
        }
        STORE.save(updated);
    }

    private static int parseId(String[] args) {
        if (args.length < 2) {
            throw new IllegalArgumentException("ID fehlt");
        }
        return Integer.parseInt(args[1]);
    }
}
