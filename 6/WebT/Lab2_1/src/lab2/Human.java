/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Human {
    String FIO;
    
    Usluga course;
    
    public Human(String fio) {
        FIO = fio;
    }
        
    public String GetFIO() {
        return FIO;
    }
    
    @Override
    public String toString() {
        return GetFIO();
    }
}
