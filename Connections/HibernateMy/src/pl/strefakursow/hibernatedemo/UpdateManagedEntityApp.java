package pl.strefakursow.hibernatedemo;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import pl.strefakursow.hibernatedemo1.entity.Employee;

public class UpdateManagedEntityApp {

	public static void main(String[] args) {
		// stworzenie obiektu Configuration
		Configuration conf = new Configuration();
		// wczytanie pliku konfiguracyjnego
		conf.configure("hibernate.cfg.xml");
		// wczytanie adnotacji
		conf.addAnnotatedClass(Employee.class);
		// stworzenie obiektu SessionFactory
		SessionFactory factory = conf.buildSessionFactory();
		// pobranie sesji
		Session session = factory.getCurrentSession();
		// rozpoczêcie transakcji
		session.beginTransaction();
		Employee employee = session.get(Employee.class, 11);
		
		employee.setLastName("Michalczyk");

		session.getTransaction().commit();
		
		
		System.out.println("zaktualizowane dane pracownika: "+ employee );
		

		factory.close();

	}

}
