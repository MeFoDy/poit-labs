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
public class Usluga {
    Admin admin;
    String nazv;
    ArrayList<Abonent> studentsList = new ArrayList<Abonent>();
    
    public Usluga(String nazv) {
        this.nazv = nazv;
    }

    @Override
    public String toString() {
        return nazv;
    }
    
}
