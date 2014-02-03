/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

import java.util.ArrayList;

/**
 *
 * @author Dark_MeFoDy
 */
public class Course {
    Teacher teacher;
    String nazv;
    ArrayList<Student> studentsList = new ArrayList<Student>();
    
    public Course(String nazv, Teacher teacher) {
        this.teacher = teacher;
        this.nazv = nazv;
        this.teacher.SetCourse(this);
    }

    @Override
    public String toString() {
        return nazv;
    }
    
    public void AddStudent(Student student) {
        studentsList.add(student);
    }
}
