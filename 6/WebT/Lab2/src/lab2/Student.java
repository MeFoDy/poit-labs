/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Student extends Human {
    
    Course course;
    
    public Student(String fio) {
        super(fio);
    }
    
    public void Learn() {
        for (int i=0; i<1000; i++) {
            // имитируем активное изучение предмета
        }
        System.out.println(FIO + " - учусь, как могу");
    }
    
    
    @Override
    public void SetCourse(Course course) {
        super.SetCourse(course);
        course.AddStudent(this);        
    }

    @Override
    public String toString() {
        return super.toString();
    }
}
