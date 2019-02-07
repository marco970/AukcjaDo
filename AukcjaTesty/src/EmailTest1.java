import java.awt.Desktop;
import java.io.IOException;
import java.net.URI;
import java.net.URISyntaxException;

public class EmailTest1 {

	public static void main(String[] args) {
		System.out.println("testuję maila");
		try {
			Desktop.getDesktop().mail( new URI( "mailto:m.kuciak@gmail.com;marcin.Kuciak@plus.pl?subject=email%20subject&body=these%20mailto%0Alinks%20are%0Acool"));
		} catch (IOException | URISyntaxException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}

}
