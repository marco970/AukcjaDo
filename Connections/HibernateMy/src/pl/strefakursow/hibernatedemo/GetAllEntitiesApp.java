package pl.strefakursow.hibernatedemo;

import java.util.List;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

import pl.strefakursow.hibernatedemo1.entity.Employee;

public class GetAllEntitiesApp {

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
		
		
		// rozpoczêcie transakcji
		session.beginTransaction();
		
		List<Employee> resList = session.createQuery("from Employee where lastName='Michalczyk'").getResultList();
		
		for(Employee employee:resList)	{
			System.out.println(employee);
		}
		
		// zapisanie pracownika
		
		session.getTransaction().commit();

		// zakoñczenie transakcji
		//session.getTransaction().commit();
		// zamkniêcie obiektu SessionFactory
		factory.close();

	}

}
