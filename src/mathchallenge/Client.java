package mathchallenge;

import java.io.*;
import java.net.*;
import java.util.Scanner;

public class Client {
    private static final String SERVER_ADDRESS = "localhost";
    private static final int PORT = 8080;

    public static void main(String[] args) {
        try (Socket socket = new Socket(SERVER_ADDRESS, PORT);
             BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
             PrintWriter out = new PrintWriter(socket.getOutputStream(), true);
             Scanner scanner = new Scanner(System.in)) {

            while (true) {
                String action = promptUser(scanner, "Choose an action: register, viewChallenges, attemptChallenge, viewApplicants, confirm, or exit:");
                if (action.equalsIgnoreCase("exit")) {
                    break;
                }

                out.println(action);
                handleAction(action.toLowerCase(), scanner, out, in);
            }
        } catch (IOException e) {
            System.err.println("Couldn't get I/O for the connection to " + SERVER_ADDRESS);
            System.exit(1);
        }
    }

    private static void handleAction(String action, Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        switch (action) {
            case "register":
                handleRegistration(scanner, out, in);
                break;
            case "viewchallenges":
                handleViewChallenges(in);
                break;
            case "attemptchallenge":
                handleAttemptChallenge(scanner, out, in);
                break;
            case "viewapplicants":
                handleViewApplicants(in);
                break;
            case "confirm":
                handleConfirm(scanner, out, in);
                break;
            default:
                System.out.println("Invalid action.");
                break;
        }
    }

    private static void handleRegistration(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        String input = promptUser(scanner, "Enter registration details (username, firstname, lastname, emailAddress, dateOfBirth, schoolRegistrationNumber, imageFile) separated by commas:");
        out.println(input);
        System.out.println("Server response: " + in.readLine());
    }

    private static void handleViewChallenges(BufferedReader in) throws IOException {
        readUntilDelimiter(in, "---");
    }

    private static void handleAttemptChallenge(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        String challengeNumber = promptUser(scanner, "Enter the challenge number to attempt:");
        out.println(challengeNumber);

        String response;
        while (!(response = in.readLine()).equals("Challenge completed.")) {
            System.out.println(response);
            if (response.startsWith("Question")) {
                String answer = promptUser(scanner, "Enter your answer:");
                out.println(answer);
            }
        }
        System.out.println("Server response: " + response);
    }

    private static void handleViewApplicants(BufferedReader in) throws IOException {
        readUntilDelimiter(in, "---");
    }

    private static void handleConfirm(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        String input = promptUser(scanner, "Enter confirmation details (yes/no username schoolNumber):");
        out.println(input);
        System.out.println("Server response: " + in.readLine());
    }

    private static String promptUser(Scanner scanner, String prompt) {
        System.out.println(prompt);
        return scanner.nextLine();
    }

    private static void readUntilDelimiter(BufferedReader in, String delimiter) throws IOException {
        String response;
        while (!(response = in.readLine()).equals(delimiter)) {
            System.out.println(response);
        }
    }
}
