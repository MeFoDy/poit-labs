/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab1.pkg1;

import java.util.*;
import java.text.DateFormat;
/**
 *
 * @author Dark_MeFoDy
 */
public class main {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Airlines[] airlines = Airlines.generateArray();
        
        String s = "Minsk";
        System.out.println("= Cписок рейсов в " + s);
        for (Airlines pr : airlines) {
            if (pr.getKuda().equalsIgnoreCase(s)) {
                System.out.println(pr);
            }
        }
                
        dayOfWeek day = dayOfWeek.MONDAY;
        System.out.println("= Cписок рейсов в " + day);
        for (Airlines pr : airlines) {
            if (pr.getDay().equals(day)) {
                System.out.println(pr);
            }
        }
        
        day = dayOfWeek.MONDAY;
        long ms = 10000000;
        Date d = new Date(ms);
        System.out.println("= Cписок рейсов в " + day + " после " + ms + " миллисекунд с начала дня");
        for (Airlines pr : airlines) {
            if (pr.getDay().equals(day) && pr.getTime().after(d)) {
                System.out.println(pr);
            }
        }
        
    }
}
