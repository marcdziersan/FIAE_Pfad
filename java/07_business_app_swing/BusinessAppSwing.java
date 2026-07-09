import javax.swing.JButton;
import javax.swing.JComboBox;
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

public class BusinessAppSwing extends JFrame {
    private final OrderStore store = new OrderStore();
    private final List<Order> orders = new ArrayList<>();
    private final DefaultTableModel model = new DefaultTableModel(new String[]{"ID", "Kunde", "Auftrag", "Netto", "MwSt", "Brutto", "Status"}, 0);
    private final JTable table = new JTable(model);
    private final JTextField customerField = new JTextField();
    private final JTextField titleField = new JTextField();
    private final JTextField netField = new JTextField();
    private final JComboBox<String> statusBox = new JComboBox<>(new String[]{"offen", "in Arbeit", "erledigt", "abgerechnet"});
    private final JLabel totalLabel = new JLabel();

    public BusinessAppSwing() {
        super("FIAE Mini-Auftragsverwaltung");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(980, 560);
        setLocationRelativeTo(null);
        orders.addAll(store.load());

        add(buildForm(), BorderLayout.NORTH);
        add(new JScrollPane(table), BorderLayout.CENTER);
        add(buildActions(), BorderLayout.SOUTH);
        refreshTable();
    }

    private JPanel buildForm() {
        JPanel panel = new JPanel(new GridLayout(2, 4, 8, 8));
        panel.add(new JLabel("Kunde")); panel.add(new JLabel("Auftrag")); panel.add(new JLabel("Netto")); panel.add(new JLabel("Status"));
        panel.add(customerField); panel.add(titleField); panel.add(netField); panel.add(statusBox);
        return panel;
    }

    private JPanel buildActions() {
        JPanel panel = new JPanel();
        JButton addButton = new JButton("Auftrag hinzufügen");
        JButton updateButton = new JButton("Aktualisieren");
        JButton deleteButton = new JButton("Löschen");
        addButton.addActionListener(e -> addOrder());
        updateButton.addActionListener(e -> updateOrder());
        deleteButton.addActionListener(e -> deleteOrder());
        panel.add(addButton); panel.add(updateButton); panel.add(deleteButton); panel.add(totalLabel);
        return panel;
    }

    private void addOrder() {
        Double net = parseNet();
        if (net == null || customerField.getText().isBlank() || titleField.getText().isBlank()) {
            JOptionPane.showMessageDialog(this, "Kunde, Auftrag und gültiger Nettobetrag sind Pflichtfelder.");
            return;
        }
        orders.add(new Order(store.nextId(orders), customerField.getText().trim(), titleField.getText().trim(), net, statusBox.getSelectedItem().toString()));
        store.save(orders);
        clearFields();
        refreshTable();
    }

    private void updateOrder() {
        Order selected = selectedOrder();
        Double net = parseNet();
        if (selected == null || net == null) return;
        selected.setCustomer(customerField.getText().trim());
        selected.setTitle(titleField.getText().trim());
        selected.setNet(net);
        selected.setStatus(statusBox.getSelectedItem().toString());
        store.save(orders);
        refreshTable();
    }

    private void deleteOrder() {
        Order selected = selectedOrder();
        if (selected == null) return;
        orders.remove(selected);
        store.save(orders);
        refreshTable();
    }

    private Order selectedOrder() {
        int row = table.getSelectedRow();
        if (row < 0) {
            JOptionPane.showMessageDialog(this, "Bitte einen Auftrag auswählen.");
            return null;
        }
        int id = (int) model.getValueAt(row, 0);
        for (Order order : orders) if (order.getId() == id) return order;
        return null;
    }

    private Double parseNet() {
        try {
            return Double.parseDouble(netField.getText().replace(',', '.'));
        } catch (NumberFormatException ex) {
            return null;
        }
    }

    private void refreshTable() {
        model.setRowCount(0);
        double totalNet = 0;
        double totalGross = 0;
        for (Order o : orders) {
            totalNet += o.getNet();
            totalGross += o.getGross();
            model.addRow(new Object[]{o.getId(), o.getCustomer(), o.getTitle(), euro(o.getNet()), euro(o.getVat()), euro(o.getGross()), o.getStatus()});
        }
        totalLabel.setText("Gesamt netto: " + euro(totalNet) + " · brutto: " + euro(totalGross));
    }

    private void clearFields() { customerField.setText(""); titleField.setText(""); netField.setText(""); statusBox.setSelectedIndex(0); }
    private String euro(double value) { return String.format("%.2f €", value); }

    public static void main(String[] args) {
        javax.swing.SwingUtilities.invokeLater(() -> new BusinessAppSwing().setVisible(true));
    }
}
