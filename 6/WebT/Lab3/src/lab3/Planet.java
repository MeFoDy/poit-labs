/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab3;

import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

/**
 *
 * @author Dark_MeFoDy
 */
public class Planet {
    List<Materik> materiks = new ArrayList<>();
    String name;
    int id;
    
    String getName(){
        return name;
    }
    int getId() {
        return id;
    }
    List<Materik> getMateriks() {
        return materiks;
    }
    
    public Planet(String name, int id) {
        this.name = name;
        this.id = id;
    }    
    
    public Planet() {
        
    }
    
    public void AddMaterik(Materik newMaterik) {
        materiks.add(newMaterik);
    }

    public int MatCount() {
        return materiks.size();
    }
    
    @Override
    public boolean equals(Object o) {
        if ( o.getClass().equals( this.getClass() ) ) {
            Planet pl = (Planet) o;
            if (pl.name.equals(name) && pl.id == id && pl.materiks.equals(materiks)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 31 * hash + Objects.hashCode(this.materiks);
        hash = 31 * hash + Objects.hashCode(this.name);
        hash = 31 * hash + this.id;
        return hash;
    }

    @Override
    public String toString() {
        return id + ": " + name;
    }
    
    
}
