/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab3;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Dark_MeFoDy
 */
public class Lab3 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        /*
         * PLANET
         */
        Planet pl = new Planet("Earth", 1);
        
        pl.AddMaterik(new Materik("Eurasia", 15));
        pl.AddMaterik(new Materik("Australia", 5));
        System.out.println("Планета " + pl);
        System.out.println("Всего материков " + pl.MatCount());
        
        try {
            System.out.println(pl.getMateriks().get(0));
            System.out.println(pl.getMateriks().get(15));
        }
        catch (IndexOutOfBoundsException ex) {
            System.out.println("Выход за пределы массива: " + ex);
        }
        
        try {
            Planet[] lp = new Planet[Integer.MAX_VALUE];
        } catch (OutOfMemoryError er) {
            System.out.println("Переполнение памяти: " + er);
        }
        
        BufferedReader in = new BufferedReader(new InputStreamReader(System.in));
        try {
            String str = in.readLine();
        } catch (IOException ex) {
            Logger.getLogger(Lab3.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        
        
        /*
         * TIGER 
         */
        Tiger tiger = new Tiger("Vasya", 10);
        tiger.Richat();
        tiger.Run();
        tiger.GetPischa();
        
        try {
            Tiger tiger1 = new Tiger("Vasya", 50);
        }
        catch (IllegalArgumentException ex) {
            System.out.println(ex);
        }
        
        
    }
}
