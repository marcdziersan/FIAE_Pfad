import javax.swing.*;
import java.awt.*;

public class NotesSwingApp {
    private final DefaultListModel<String> listModel = new DefaultListModel<>();
    private final JTextField titleField = new JTextField();
    private final JTextArea contentArea = new JTextArea(5, 30);

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> new NotesSwingApp().show());
    }

    private void show() {
        JFrame frame = new JFrame("FIAE Swing Notiz-App");
        frame.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        frame.setSize(640, 420);
        frame.setLocationRelativeTo(null);

        JPanel form = new JPanel(new BorderLayout(8, 8));
        JPanel fields = new JPanel(new GridLayout(0, 1, 6, 6));
        fields.add(new JLabel("Titel"));
        fields.add(titleField);
        fields.add(new JLabel("Inhalt"));
        fields.add(new JScrollPane(contentArea));
        JButton addButton = new JButton("Notiz hinzufügen");
        addButton.addActionListener(event -> addNote());
        form.add(fields, BorderLayout.CENTER);
        form.add(addButton, BorderLayout.SOUTH);

        JList<String> notesList = new JList<>(listModel);

        frame.add(form, BorderLayout.NORTH);
        frame.add(new JScrollPane(notesList), BorderLayout.CENTER);
        frame.setVisible(true);
    }

    private void addNote() {
        String title = titleField.getText().trim();
        String content = contentArea.getText().trim();
        if (title.length() < 3 || content.length() < 3) {
            JOptionPane.showMessageDialog(null, "Titel und Inhalt müssen mindestens 3 Zeichen haben.");
            return;
        }
        listModel.addElement(title + " - " + content);
        titleField.setText("");
        contentArea.setText("");
    }
}
