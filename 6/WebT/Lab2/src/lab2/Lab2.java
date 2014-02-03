/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Lab2 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Teacher t1 = new Teacher("Ivanov Ivan Ivanovich"), t2 = new Teacher("Petrov V.V.");
        
        Course c1 = new Course("Literature", t1), c2 = new Course("Random Programming", t2);
        
        Student s1 = new Student("Tutkin V.V."), s2 = new Student("Pupkin O.O.");
        
        System.out.println(t1 + " объявил курс " + c1);
        System.out.println(t2 + " объявил курс " + c2);
        
        s1.SetCourse(t1.DeclareCourse());
        System.out.println(s1 + " приступил к " + t1.DeclareCourse());
        s2.SetCourse(t2.DeclareCourse());
        System.out.println(s2 + " приступил к " + t2.DeclareCourse());
        
        s1.Learn();
        s2.Learn();
        
        Archive archive = new Archive();
        
        t1.StopCourse(archive);
        t2.StopCourse(archive);
    }
}
