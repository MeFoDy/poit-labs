/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package newpackage;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;


public class auth extends HttpServlet {

    /**
     * Processes requests for both HTTP
     * <code>GET</code> and
     * <code>POST</code> methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    private static Connection getConnection() throws Exception {
        Connection con = null;
        try {

            Class.forName("org.gjt.mm.mysql.Driver").newInstance();

            con = DriverManager.getConnection("jdbc:mysql://localhost/test", "root", "1234");
        } catch (Exception ex) {
            throw ex;
        }

        return con;
    }
/**
     * Processes requests for both HTTP
     * <code>GET</code> and
     * <code>POST</code> methods.
     *
     */
    public static boolean Register(String log, String pass) throws SQLException, Exception {
        if ((log == null) || (pass == null) || (log.equals("")) || (pass.equals(""))) {
            return false;
        }

        /*int a = 0;
         a+=log.indexOf(";");
         a+=log.indexOf("'");
         a+=log.indexOf(";");
        
         if (a != 0)
         {
         return false;
         }
         */
        int passHash = pass.hashCode();

        Connection con = getConnection();
        String query = "INSERT INTO `user` (`login`,`pass`) VALUES ('" + log + "','" + passHash + "')";

        int q;
        try {
            PreparedStatement ps = con.prepareStatement(query);
            q = ps.executeUpdate();
        } catch (Exception ex) {
            return false;
        }

        if (q == 0) {
            return false;
        }

        return true;
    }

    public static boolean IsLogin(String log, String pass) throws SQLException, Exception {

        if ((log == null) || (pass == null) || (log.equals("")) || (pass.equals(""))) {
            return false;
        }

        int passHash = Integer.parseInt(pass);

        /*int a = 0;
         a+=log.indexOf(";");
         a+=log.indexOf("'");
         a+=log.indexOf(";");
        
         if (a != 0)
         {
         return false;
         }*/


        Connection con = getConnection();

        String query = "SELECT * FROM `user` WHERE login='" + log + "'";

        PreparedStatement ps = con.prepareStatement(query);
        ResultSet rs = ps.executeQuery();

        if (!rs.next()) {

            return false;

        }

        int passFromBase = Integer.parseInt(rs.getString("pass"));

        if (passFromBase != passHash) {

            return false;
        }

        return true;
    }

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException, Exception {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();

        String log = request.getParameter("login");
        String pass = request.getParameter("pass");

        if ((log == null) || (pass == null) || (log.equals("")) || (pass.equals(""))) {
            out.println("Bad request");
            return;
        }

        int passHash = pass.hashCode();

        Connection con = getConnection();

        String query = "SELECT * FROM `user` WHERE login=" + log;

        PreparedStatement ps = con.prepareStatement(query);
        ResultSet rs = ps.executeQuery();

        if (!rs.next()) {
            out.println("Нет такого пользователя.");
            return;

        }

        int passFromBase = Integer.parseInt(rs.getString("pass"));

        if (passFromBase != passHash) {
            out.print("Пароль неверный");
            return;
        }



        try {
            /* TODO output your page here. You may use following sample code. */
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet auth</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet auth at " + request.getContextPath() + "</h1>");
            out.println("</body>");
            out.println("</html>");
        } finally {
            out.close();
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP
     * <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        try {
            processRequest(request, response);
        } catch (Exception ex) {
            Logger.getLogger(auth.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    /**
     * Handles the HTTP
     * <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        try {
            processRequest(request, response);
        } catch (Exception ex) {
            Logger.getLogger(auth.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>
}
