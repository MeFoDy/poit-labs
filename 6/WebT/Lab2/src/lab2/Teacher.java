/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Teacher extends Human {
        
    public Teacher(String fio) {
        super(fio);
    }
        
    public Course DeclareCourse() {
        if (course != null) {
            return course;
        }
        else {
            return null;
        }
    }
    
    public void StopCourse(Archive archive) {
        System.out.println(course + " окончен");
        for (int i = 0; i<course.studentsList.size(); i++) {
            // сложная логика подсчета оценки для конкретного студента
            Mark mark = new Mark(10);
            ArchiveField af = new ArchiveField(this, course, course.studentsList.get(i), mark);
            archive.AddField(af);
            System.out.println(this + " - ставлю " 
                    + course.studentsList.get(i) 
                    + " оценку " + mark.GetMark()
                    + " за предмет " + course);
        }
    }
     
    @Override
    public String toString() {
        return super.toString();
    }
}
