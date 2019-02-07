package pl.strefakursow.hibernatedemo;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import pl.strefakursow.hibernatedemo1.entity.Employee;

public class GetEntityApp {

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
		// stworzenie obiektu
		Employee employee = new Employee();
		
		employee.setFirstName("Jacek");
		employee.setLastName("Januszewski");
		employee.setSalary(7800);
		// rozpoczêcie transakcji
		session.beginTransaction();
		// zapisanie pracownika
		Integer id = (Integer) session.save(employee);
		session.getTransaction().commit();
		
		session = factory.getCurrentSession();
		session.beginTransaction();
		Employee retrEmployee = session.get(Employee.class, id);
		
		session.getTransaction().commit();
		
		System.out.println("dane: "+ retrEmployee );

		// zamkniêcie obiektu SessionFactory
		factory.close();
	}

}
