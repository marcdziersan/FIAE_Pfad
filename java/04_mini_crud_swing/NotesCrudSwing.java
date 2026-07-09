import javax.swing.*;
import java.awt.*;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class NotesCrudSwing {
    private final NoteStore store = new NoteStore();
    private final DefaultListModel<Note> listModel = new DefaultListModel<>();
    private final JList<Note> notesList = new JList<>(listModel);
    private final JTextField titleField = new JTextField();
    private final JTextArea contentArea = new JTextArea(6, 32);
    private final JCheckBox doneBox = new JCheckBox("Erledigt");
    private List<Note> notes = new ArrayList<>();

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> new NotesCrudSwing().show());
    }

    private void show() {
        try {
            notes = store.load();
        } catch (IOException e) {
            showError("Daten konnten nicht geladen werden: " + e.getMessage());
        }

        JFrame frame = new JFrame("FIAE Mini CRUD Swing");
        frame.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        frame.setSize(820, 520);
        frame.setLocationRelativeTo(null);

        notesList.setCellRenderer((list, note, index, selected, focus) -> {
            String status = note.isDone() ? "[x]" : "[ ]";
            JLabel label = new JLabel(status + " #" + note.getId() + " " + note.getTitle());
            label.setOpaque(true);
            label.setBorder(BorderFactory.createEmptyBorder(8, 8, 8, 8));
            label.setBackground(selected ? new Color(219, 234, 254) : Color.WHITE);
            return label;
        });
        notesList.addListSelectionListener(event -> fillFormFromSelection());

        JPanel form = new JPanel(new BorderLayout(8, 8));
        JPanel fields = new JPanel(new GridLayout(0, 1, 6, 6));
        fields.add(new JLabel("Titel"));
        fields.add(titleField);
        fields.add(new JLabel("Inhalt"));
        fields.add(new JScrollPane(contentArea));
        fields.add(doneBox);
        form.add(fields, BorderLayout.CENTER);

        JPanel buttons = new JPanel(new FlowLayout(FlowLayout.LEFT));
        JButton addButton = new JButton("Neu speichern");
        JButton updateButton = new JButton("Auswahl ändern");
        JButton deleteButton = new JButton("Auswahl löschen");
        JButton clearButton = new JButton("Formular leeren");
        addButton.addActionListener(event -> addNote());
        updateButton.addActionListener(event -> updateNote());
        deleteButton.addActionListener(event -> deleteNote());
        clearButton.addActionListener(event -> clearForm());
        buttons.add(addButton);
        buttons.add(updateButton);
        buttons.add(deleteButton);
        buttons.add(clearButton);
        form.add(buttons, BorderLayout.SOUTH);

        JSplitPane splitPane = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, new JScrollPane(notesList), form);
        splitPane.setDividerLocation(300);

        frame.add(splitPane, BorderLayout.CENTER);
        refreshList();
        frame.setVisible(true);
    }

    private void addNote() {
        String title = titleField.getText().trim();
        String content = contentArea.getText().trim();
        if (!isValid(title, content)) return;
        notes.add(new Note(store.nextId(notes), title, content, doneBox.isSelected()));
        persistAndRefresh();
        clearForm();
    }

    private void updateNote() {
        int index = notesList.getSelectedIndex();
        if (index < 0) {
            showError("Bitte zuerst eine Notiz auswählen.");
            return;
        }
        String title = titleField.getText().trim();
        String content = contentArea.getText().trim();
        if (!isValid(title, content)) return;
        Note selected = listModel.getElementAt(index);
        for (int i = 0; i < notes.size(); i++) {
            if (notes.get(i).getId() == selected.getId()) {
                notes.set(i, selected.withValues(title, content, doneBox.isSelected()));
                break;
            }
        }
        persistAndRefresh();
    }

    private void deleteNote() {
        int index = notesList.getSelectedIndex();
        if (index < 0) {
            showError("Bitte zuerst eine Notiz auswählen.");
            return;
        }
        Note selected = listModel.getElementAt(index);
        notes.removeIf(note -> note.getId() == selected.getId());
        persistAndRefresh();
        clearForm();
    }

    private void fillFormFromSelection() {
        Note note = notesList.getSelectedValue();
        if (note == null) return;
        titleField.setText(note.getTitle());
        contentArea.setText(note.getContent());
        doneBox.setSelected(note.isDone());
    }

    private boolean isValid(String title, String content) {
        if (title.length() < 3 || content.length() < 3) {
            showError("Titel und Inhalt müssen mindestens 3 Zeichen haben.");
            return false;
        }
        return true;
    }

    private void clearForm() {
        notesList.clearSelection();
        titleField.setText("");
        contentArea.setText("");
        doneBox.setSelected(false);
    }

    private void persistAndRefresh() {
        try {
            store.save(notes);
            refreshList();
        } catch (IOException e) {
            showError("Daten konnten nicht gespeichert werden: " + e.getMessage());
        }
    }

    private void refreshList() {
        listModel.clear();
        for (Note note : notes) {
            listModel.addElement(note);
        }
    }

    private void showError(String message) {
        JOptionPane.showMessageDialog(null, message, "Hinweis", JOptionPane.WARNING_MESSAGE);
    }
}
