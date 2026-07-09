import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.DefaultTableModel;
import java.awt.BorderLayout;
import java.awt.GridLayout;
import java.util.ArrayList;
import java.util.List;

public class PhoneBookSwing extends JFrame {
    private final ContactStore store = new ContactStore();
    private final List<Contact> contacts = new ArrayList<>();
    private final DefaultTableModel model = new DefaultTableModel(new String[]{"ID", "Name", "Telefon", "E-Mail"}, 0);
    private final JTable table = new JTable(model);
    private final JTextField nameField = new JTextField();
    private final JTextField phoneField = new JTextField();
    private final JTextField emailField = new JTextField();
    private final JTextField searchField = new JTextField();

    public PhoneBookSwing() {
        super("FIAE Telefonbuch");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(780, 520);
        setLocationRelativeTo(null);
        contacts.addAll(store.load());

        add(buildForm(), BorderLayout.NORTH);
        add(new JScrollPane(table), BorderLayout.CENTER);
        add(buildActions(), BorderLayout.SOUTH);
        refreshTable(contacts);
    }

    private JPanel buildForm() {
        JPanel panel = new JPanel(new GridLayout(2, 4, 8, 8));
        panel.add(new JLabel("Name")); panel.add(new JLabel("Telefon")); panel.add(new JLabel("E-Mail")); panel.add(new JLabel("Suche"));
        panel.add(nameField); panel.add(phoneField); panel.add(emailField); panel.add(searchField);
        return panel;
    }

    private JPanel buildActions() {
        JPanel panel = new JPanel();
        JButton addButton = new JButton("Hinzufügen");
        JButton updateButton = new JButton("Aktualisieren");
        JButton deleteButton = new JButton("Löschen");
        JButton searchButton = new JButton("Suchen");
        JButton resetButton = new JButton("Alle anzeigen");
        addButton.addActionListener(e -> addContact());
        updateButton.addActionListener(e -> updateContact());
        deleteButton.addActionListener(e -> deleteContact());
        searchButton.addActionListener(e -> searchContacts());
        resetButton.addActionListener(e -> refreshTable(contacts));
        panel.add(addButton); panel.add(updateButton); panel.add(deleteButton); panel.add(searchButton); panel.add(resetButton);
        return panel;
    }

    private void addContact() {
        if (nameField.getText().isBlank() || phoneField.getText().isBlank()) {
            JOptionPane.showMessageDialog(this, "Name und Telefon sind Pflichtfelder.");
            return;
        }
        contacts.add(new Contact(store.nextId(contacts), nameField.getText().trim(), phoneField.getText().trim(), emailField.getText().trim()));
        store.save(contacts);
        clearFields();
        refreshTable(contacts);
    }

    private void updateContact() {
        Contact selected = selectedContact();
        if (selected == null) return;
        selected.setName(nameField.getText().trim());
        selected.setPhone(phoneField.getText().trim());
        selected.setEmail(emailField.getText().trim());
        store.save(contacts);
        refreshTable(contacts);
    }

    private void deleteContact() {
        Contact selected = selectedContact();
        if (selected == null) return;
        contacts.remove(selected);
        store.save(contacts);
        refreshTable(contacts);
    }

    private Contact selectedContact() {
        int row = table.getSelectedRow();
        if (row < 0) {
            JOptionPane.showMessageDialog(this, "Bitte einen Kontakt auswählen.");
            return null;
        }
        int id = (int) model.getValueAt(row, 0);
        for (Contact contact : contacts) if (contact.getId() == id) return contact;
        return null;
    }

    private void searchContacts() {
        String term = searchField.getText().toLowerCase();
        List<Contact> hits = new ArrayList<>();
        for (Contact contact : contacts) {
            String text = (contact.getName() + " " + contact.getPhone() + " " + contact.getEmail()).toLowerCase();
            if (text.contains(term)) hits.add(contact);
        }
        refreshTable(hits);
    }

    private void refreshTable(List<Contact> rows) {
        model.setRowCount(0);
        for (Contact c : rows) model.addRow(new Object[]{c.getId(), c.getName(), c.getPhone(), c.getEmail()});
    }

    private void clearFields() { nameField.setText(""); phoneField.setText(""); emailField.setText(""); }

    public static void main(String[] args) {
        javax.swing.SwingUtilities.invokeLater(() -> new PhoneBookSwing().setVisible(true));
    }
}
