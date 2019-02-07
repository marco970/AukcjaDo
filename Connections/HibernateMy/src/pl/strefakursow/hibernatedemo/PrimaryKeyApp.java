package pl.strefakursow.hibernatedemo;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import pl.strefakursow.hibernatedemo1.entity.Employee;

public class PrimaryKeyApp {

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
		// stworzenie 3 obiektów
		Employee employee1 = new Employee();
		
		employee1.setFirstName("Wies³aw");
		employee1.setLastName("Baliñski");
		employee1.setSalary(11200);
		
		Employee employee2 = new Employee();
		employee2.setFirstName("Henryka");
		employee2.setLastName("Grodzicka");
		employee2.setSalary(10400);
		
		Employee employee3 = new Employee();
		employee3.setFirstName("Katarzyna");
		employee3.setLastName("Michalczyk");
		employee3.setSalary(12600);
		
		// rozpoczêcie transakcji
		session.beginTransaction();
		// zapisanie 3 pracowników
		session.save(employee1);
		session.save(employee2);
		session.save(employee3);
		// zakoñczenie transakcji
		session.getTransaction().commit();
		// zamkniêcie obiektu SessionFactory
		factory.close();
	

	}

}
