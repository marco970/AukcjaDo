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
		// stworzenie 3 obiekt�w
		Employee employee1 = new Employee();
		
		employee1.setFirstName("Wies�aw");
		employee1.setLastName("Bali�ski");
		employee1.setSalary(11200);
		
		Employee employee2 = new Employee();
		employee2.setFirstName("Henryka");
		employee2.setLastName("Grodzicka");
		employee2.setSalary(10400);
		
		Employee employee3 = new Employee();
		employee3.setFirstName("Katarzyna");
		employee3.setLastName("Michalczyk");
		employee3.setSalary(12600);
		
		// rozpocz�cie transakcji
		session.beginTransaction();
		// zapisanie 3 pracownik�w
		session.save(employee1);
		session.save(employee2);
		session.save(employee3);
		// zako�czenie transakcji
		session.getTransaction().commit();
		// zamkni�cie obiektu SessionFactory
		factory.close();
	

	}

}
