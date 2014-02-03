/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab4_2;

import java.util.Random;

/**
 *
 * @author Dark_MeFoDy
 */
public class Lab4_2 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        BlackBox bb = new BlackBox();
        
        for (Double z = 25.; z>14.; z--) {
            bb.add(z);
        }
        for (int z = 14; z>-2; z--) {
            System.out.println(bb.getKElem(z));
        }
    }
}
