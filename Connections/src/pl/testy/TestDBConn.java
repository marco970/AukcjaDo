package pl.testy;

import java.sql.Connection;
import java.sql.DriverManager;

public class TestDBConn {

	public static void main(String[] args) {
		String jdbcUrl = "jdbc:mysql://localhost:3306/library?useSSL=FALSE&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
		String user ="skstudent";
		String password = "skstudent";
		
		
		try {
			System.out.println("��cz� z " + jdbcUrl);
			Connection myConn = DriverManager.getConnection(jdbcUrl, user, password);
			System.out.println("po��czono");
		}
		catch (Exception ext)	{
			ext.printStackTrace();
		}
	}

}
