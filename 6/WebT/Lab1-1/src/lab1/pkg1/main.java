/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab1.pkg1;

import java.util.*;
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
        Product[] products = Product.generateArray();
        String s = "Velosiped";
        // список товаров для заданного наименования
        System.out.println("= Cписок товаров для заданного наименования " + s);
        for (Product pr : products) {
            if (pr.getName().equalsIgnoreCase(s)) {
                System.out.println(pr);
            }
        }
        
        // список товаров для заданного наименования, цена которых не превосходит заданную
        double c = 17.0;
        s = "Velosiped";
        System.out.println("= Cписок товаров для заданного наименования " +s + ", цена которых не превосходит заданную " + c);
        for (Product pr : products) {
            if (pr.getName().equalsIgnoreCase(s) && pr.getCost() <= c) {
                System.out.println(pr);
            }
        }
        
        // список товаров, срок хранения которых больше заданного
        Date d = new Date(100000000);
        System.out.println("= Cписок товаров, срок хранения которых больше заданного " + d);
        for (Product pr : products) {
            if (pr.getGodenDo().after(d)) {
                System.out.println(pr);
            }
        }
        
    }
}
