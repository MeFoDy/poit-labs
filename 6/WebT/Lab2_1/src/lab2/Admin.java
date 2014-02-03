/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Admin extends Human {
        
    public Admin(String fio) {
        super(fio);
    }
        
    public void ChangeNumber(Abonent ab, String number) {
        ab.ChangeNumber(number);
        System.out.println(this + " сменил " + ab + " номер на " + number);
    }
    
    public Usluga ChangeUsluga(Usluga usluga) {
        System.out.println(this + " - Я изменил услугу" + usluga);
        return usluga;
    }
    
    public void Otkl(Abonent ab) {
        System.out.println(this + " - Я отключил абонента " + ab + ". LOL.");
    }
     
    @Override
    public String toString() {
        return super.toString();
    }
}
