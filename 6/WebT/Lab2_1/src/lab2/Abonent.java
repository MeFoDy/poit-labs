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
public class Abonent extends Human {
    
    Usluga usluga;
    String number;
    
    public Abonent(String fio, String number) {
        super(fio);
    }
    
    public Schet Oplatit(Usluga list) {
        System.out.println(this + " оплатил счет на сумму " + new Schet(10).GetSchet());
        return new Schet(10);
    }
    
    public void ChangeNumber(String number) {
        this.number = number;
    }
    
    public void Popros(Admin admin, String number) {
        System.out.println(this + " попросил " + admin + " поменять номер на " + number);
        admin.ChangeNumber(this, number);
    }
    
    public void Otkaz() {
        System.out.println(this + " - Я отказываюсь от услуг");
    }
    
    @Override
    public String toString() {
        return super.toString();
    }
}
