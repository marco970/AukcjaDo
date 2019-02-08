package pl.aukcja.gui;

import java.awt.Color;
import java.awt.FlowLayout;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.SwingUtilities;

public class AukcjaScreen extends JFrame {
	public AukcjaScreen() {

	    SwingUtilities.invokeLater(new Runnable() {

	      @Override
	      public void run() {
	        createGui();
	      }
	    });
	  }
	protected void createGui() {
	    // ustalenie tytułu okna
	    setTitle("Okno aplikacji");


	    setLayout(new FlowLayout());

	    // tworzenie komponentów np.
	    JLabel lab = new JLabel("Etykieta");
	    JButton b = new JButton("Przycisk");

	    // Ustalenie własciwości komponentów,
	    // np:
	    lab.setForeground(Color.red);
	    b.setForeground(Color.blue);

	    // Dodanie komponentów do okna np.
	    add(lab);
	    add(b);

	    // Ustalenie domyślnej operacji zamknięcia okna
	    setDefaultCloseOperation(EXIT_ON_CLOSE);

	    // ustalenie rozmiarów okna, np.:
	    pack();

	    // ustalenie położenia okna np. wycentrowanie

	    setLocationRelativeTo(null);

	    // pokazanie okna
	    setVisible(true);
	  }
}
