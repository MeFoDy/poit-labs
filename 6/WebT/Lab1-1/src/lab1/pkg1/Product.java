package lab1.pkg1;

import java.util.*;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Dark_MeFoDy
 */
public class Product {
    
    private int id;
    private String name;
    private String UPC;
    private double cost;
    private Date godenDo;
    private int count;
    
    private Product[] products;
    /**
     * Конструктор класса Product
     * 
     * @param id идентификатор продукта
     * @param name наименование продукта
     * @param UPC код UPC продукта
     * @param cost цена единицы продукта
     * @param godenDo срок годности товара
     * @param count количество единиц продукта
     */
    public Product(int id, String name, String UPC, double cost, Date godenDo, int count) {
        this.id = id;
        this.name = name;
        this.UPC = UPC;
        this.cost = cost;
        this.godenDo = godenDo;
        this.count = count;
    }
    
    public static Product[] generateArray() {
        Product[] productArray;
        productArray = new Product[10];
        
        productArray[0] = new Product(1, "Velosiped", "00001111", 15.0, new Date(1000000000), 10);
        productArray[1] = new Product(2, "Velosiped", "00001234", 20.0, new Date(1500000000), 15);
        productArray[2] = new Product(3, "Computer", "00000007", 100.5, new Date(500000000), 100);
        productArray[3] = new Product(4, "Computer", "11111111", 115.333, new Date(500000000), 100);
        productArray[4] = new Product(5, "Product", "00001111", 20.0, new Date(1000000000), 10);
        productArray[5] = new Product(6, "SomeProduct", "00001111", 25.0, new Date(200000000), 100);
        productArray[6] = new Product(7, "Myaaaaso", "00001111", 1000.0, new Date(300000000), 16);
        productArray[9] = new Product(8, "Oslik", "00001111", 3.0, new Date(1000000000), 19);
        productArray[7] = new Product(9, "Suslik", "00001111", 1.0, new Date(1000000000), 17);
        productArray[8] = new Product(10, "Paukan", "00001111", 2.0, new Date(1000000000), 18);
        
        return productArray;
    }
    
    @Override
    public String toString() {
        return "Product: " + name + ", UPC " + UPC + ", cost: " + cost + ", date: " + godenDo.toString();
    }
        
    public int getId() {
        return id;
    }
    public String getName() {
        return name;
    }
    public String getUPC() {
        return UPC;
    }
    public double getCost(){
        return cost;
    }
    public Date getGodenDo() {
        return godenDo;
    }
    public int getCount() {
        return count;
    }
    
    public void setId(int id) {
        this.id = id;
    }
    public void setName(String name) {
        this.name = name;
    }
    public void setUPC(String UPC) {
        this.UPC = UPC;
    }
    public void setCost(double cost) {
        this.cost = cost;
    }
    public void setGodenDo(Date godenDo) {
        this.godenDo = godenDo;
    }
    public void setCount(int count) {
        this.count = count;
    }
    
}
