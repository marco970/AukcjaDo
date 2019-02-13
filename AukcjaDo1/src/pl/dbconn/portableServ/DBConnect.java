package pl.dbconn.portableServ;

import java.awt.EventQueue;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

import javax.swing.JFileChooser;
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
	String defaultPath;

public DBConnect()        {
	
	defaultPath = new JFileChooser().getFileSystemView().getDefaultDirectory().toString();
	System.out.println(defaultPath);
	
	try {
		Process proc = Runtime.getRuntime().exec(defaultPath+"\\000_rough\\mysql\\bin\\mysqld_usbwv8.exe");
		//Process process = new ProcessBuilder("U:\\git\\AukcjaDo\\1\\AukcjaDo1\\000_rough\\usbwebserver.exe").start();
	} catch (IOException e1) {
		e1.printStackTrace();
	}
	
	//mysqld_usbwv8.exe
	
	
	frame = new JFrame("siema");
	frame.setSize(790, 100);
	JPanel pane = new JPanel();                          
	lab = new JLabel("hello");
	pane.add(lab);
	frame.add(pane);
	frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	frame.setVisible(false);
	
	for (int i = 0; i < 4; i++) {
		try {
			Thread.sleep(1000);
		} catch (InterruptedException e1) {
			e1.printStackTrace();
		}
		if (processCheck("mysqld_usbwv8.exe")) {
			
			String jdbcUrl = "jdbc:mysql://localhost:3307/portableu?useSSL=FALSE&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
			String user = "root";
			String password = "usbw";

			try {
				myConn = DriverManager.getConnection(jdbcUrl, user, password);
				System.out.println("połączono");
				break;
			} catch (SQLException exc) {
				System.out.println("Nieudane połączenie z " + jdbcUrl);
			}
		} 
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
	
	public boolean processCheck(String processName)	{
		String findProcess = "mysqld_usbwv8.exe";
		String filenameFilter = "/nh /fi \"Imagename eq "+findProcess+"\"";
		String tasksCmd = System.getenv("windir") +"/system32/tasklist.exe "+filenameFilter;

		Process p = null;
		try {
			p = Runtime.getRuntime().exec(tasksCmd);
			//System.out.println(p.toString()+"xxxx");
		} catch (IOException e2) {
			e2.printStackTrace();
		}
		BufferedReader input = new BufferedReader(new InputStreamReader(p.getInputStream()));

		ArrayList<String> procs = new ArrayList<String>();
		String line = null;
		try {
			while ((line = input.readLine()) != null) 
			    procs.add(line);
				//System.out.println(procs.toString()+"****");
		} catch (IOException e2) {
			e2.printStackTrace();
		}

		try {
			input.close();
		} catch (IOException e2) {
			e2.printStackTrace();
		}

		Boolean processFound = procs.stream().filter(row -> row.indexOf(findProcess) > -1).count() > 0;
		
		System.out.println(processFound);
		
		return processFound;
	}
	
	
}
