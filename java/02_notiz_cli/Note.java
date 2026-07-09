public class Note {
    private final int id;
    private final String title;
    private final String content;
    private final boolean done;

    public Note(int id, String title, String content, boolean done) {
        this.id = id;
        this.title = title;
        this.content = content;
        this.done = done;
    }

    public int getId() { return id; }
    public String getTitle() { return title; }
    public String getContent() { return content; }
    public boolean isDone() { return done; }

    public Note withDone(boolean value) {
        return new Note(id, title, content, value);
    }

    public String toFileLine() {
        return id + "\t" + escape(title) + "\t" + escape(content) + "\t" + done;
    }

    public static Note fromFileLine(String line) {
        String[] parts = line.split("\t", -1);
        int id = Integer.parseInt(parts[0]);
        String title = unescape(parts[1]);
        String content = unescape(parts[2]);
        boolean done = Boolean.parseBoolean(parts[3]);
        return new Note(id, title, content, done);
    }

    private static String escape(String value) {
        return value.replace("\\", "\\\\").replace("\t", "\\t").replace("\n", "\\n");
    }

    private static String unescape(String value) {
        return value.replace("\\n", "\n").replace("\\t", "\t").replace("\\\\", "\\");
    }
}
