import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;
import java.awt.BorderLayout;
import java.awt.GridLayout;

public class CalculatorSwing extends JFrame {
    private final JTextField display = new JTextField("0");
    private double storedValue = 0.0;
    private String operator = "+";
    private boolean startNewNumber = true;

    public CalculatorSwing() {
        super("FIAE Taschenrechner");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(360, 460);
        setLocationRelativeTo(null);

        display.setEditable(false);
        display.setHorizontalAlignment(JTextField.RIGHT);
        display.setFont(display.getFont().deriveFont(28f));
        add(display, BorderLayout.NORTH);

        JPanel panel = new JPanel(new GridLayout(5, 4, 6, 6));
        String[] buttons = {
            "7", "8", "9", "/",
            "4", "5", "6", "*",
            "1", "2", "3", "-",
            "0", ",", "=", "+",
            "C", "CE", "+/-", "%"
        };
        for (String text : buttons) {
            JButton button = new JButton(text);
            button.addActionListener(e -> handle(text));
            panel.add(button);
        }
        add(panel, BorderLayout.CENTER);
    }

    private void handle(String text) {
        if (text.matches("[0-9]")) {
            appendDigit(text);
        } else if (text.equals(",")) {
            appendComma();
        } else if (text.matches("[+\\-*/]")) {
            applyOperator(text);
        } else if (text.equals("=")) {
            calculateResult();
        } else if (text.equals("C")) {
            display.setText("0"); storedValue = 0; operator = "+"; startNewNumber = true;
        } else if (text.equals("CE")) {
            display.setText("0"); startNewNumber = true;
        } else if (text.equals("+/-")) {
            double value = currentValue() * -1; display.setText(format(value));
        } else if (text.equals("%")) {
            double value = currentValue() / 100; display.setText(format(value));
        }
    }

    private void appendDigit(String digit) {
        if (startNewNumber || display.getText().equals("0")) {
            display.setText(digit);
            startNewNumber = false;
        } else {
            display.setText(display.getText() + digit);
        }
    }

    private void appendComma() {
        if (startNewNumber) {
            display.setText("0,");
            startNewNumber = false;
        } else if (!display.getText().contains(",")) {
            display.setText(display.getText() + ",");
        }
    }

    private void applyOperator(String nextOperator) {
        storedValue = calculate(storedValue, currentValue(), operator);
        display.setText(format(storedValue));
        operator = nextOperator;
        startNewNumber = true;
    }

    private void calculateResult() {
        try {
            storedValue = calculate(storedValue, currentValue(), operator);
            display.setText(format(storedValue));
            operator = "+";
            startNewNumber = true;
        } catch (ArithmeticException ex) {
            JOptionPane.showMessageDialog(this, ex.getMessage(), "Fehler", JOptionPane.ERROR_MESSAGE);
            display.setText("0");
            startNewNumber = true;
        }
    }

    private double currentValue() {
        return Double.parseDouble(display.getText().replace(',', '.'));
    }

    private double calculate(double a, double b, String op) {
        return switch (op) {
            case "+" -> a + b;
            case "-" -> a - b;
            case "*" -> a * b;
            case "/" -> {
                if (b == 0.0) throw new ArithmeticException("Division durch 0 ist nicht erlaubt.");
                yield a / b;
            }
            default -> b;
        };
    }

    private String format(double value) {
        if (value == (long) value) return String.valueOf((long) value);
        return String.valueOf(value).replace('.', ',');
    }

    public static void main(String[] args) {
        javax.swing.SwingUtilities.invokeLater(() -> new CalculatorSwing().setVisible(true));
    }
}
