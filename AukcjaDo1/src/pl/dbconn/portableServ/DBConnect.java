package pl.dbconn.portableServ;

import java.awt.EventQueue;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;

public class DBConnect {   
	private static Connection myConn;
	private static Statement stmt;
	static JFrame frame;
	static JLabel lab;
                //private static String driverName = "com.mysql.jdbc.Driver";

public DBConnect()        {

	frame = new JFrame("siema");
	frame.setSize(790, 100);
	JPanel pane = new JPanel();                          
	lab = new JLabel("hello");
	pane.add(lab);
	frame.add(pane);
	frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	frame.setVisible(false);

	String jdbcUrl = "jdbc:mysql://localhost:3307/test_h_1?useSSL=FALSE&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
	String user ="portableU";
	String password = "usbw";

	try {
		Thread.sleep(0);
	} catch (InterruptedException e) {
		e.printStackTrace();
	}
	try {
		myConn = DriverManager.getConnection(jdbcUrl, user, password);
		System.out.println("połączono");
	} catch (SQLException exc) {
		System.out.println("Nieudane połączenie z " + jdbcUrl);
	}
}
	public static void main(String[] args) {
	EventQueue.invokeLater(new Runnable() {
		@Override
		public void run() {
			new DBConnect();
		}
	});
	}
}
