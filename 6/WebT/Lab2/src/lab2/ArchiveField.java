/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class ArchiveField {
    
    Teacher teacher;
    Course course;
    Student student;
    Mark mark;
    
    public ArchiveField(Teacher teacher, Course course, Student student, Mark mark) {
        this.teacher = teacher;
        this.course = course;
        this.mark = mark;
        this.student = student;
    }
    
    public Teacher GetTeacher() {
        return teacher;
    }
    public Course GetCourse() {
        return course;
    }    
    public Mark GetMark() {
        return mark;
    }    
    public Student GetStudent() {
        return student;
    }
}
