package pl.strefakursow.hibernatedemo;

import org.hibernate.*;
import org.hibernate.cfg.Configuration;

import pl.strefakursow.hibernatedemo1.entity.Employee;

public class SaveEntityApp {

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
		employee.setIdEmployee(2);
		employee.setFirstName("Piotr");
		employee.setLastName("Nowicki");
		employee.setSalary(9800);
		// rozpoczêcie transakcji
		session.beginTransaction();
		// zapisanie pracownika
		session.save(employee);
		// zakoñczenie transakcji
		session.getTransaction().commit();
		// zamkniêcie obiektu SessionFactory
		factory.close();

	}

}
