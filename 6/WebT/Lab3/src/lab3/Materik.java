/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab3;

import java.util.Objects;

/**
 *
 * @author Dark_MeFoDy
 */
public class Materik {
    String name;
    int size;
    
    String getName() {
        return name;
    }
    int getSize() {
        return size;
    }
    
    public Materik(String name, int size) {
        this.name = name;
        this.size = size;
    }

    @Override
    public boolean equals(Object o) {
        if ( o.getClass().equals( this.getClass() ) ) {
            Materik mat = (Materik)o;
            if (mat.getName().equals(name) && mat.getSize() == size) {
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
        hash = 59 * hash + Objects.hashCode(this.name);
        hash = 59 * hash + this.size;
        return hash;
    }

    @Override
    public String toString() {
        return name;
    }
}
