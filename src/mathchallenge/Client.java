package mathchallenge;

import java.io.*;
import java.net.*;
import java.util.Scanner;

public class Client {
    private static final String SERVER_ADDRESS = "localhost";
    private static final int PORT = 8080;
    private static final int SERVER_PORT = PORT;

    public static void main(String[] args) {
        try (Socket socket = new Socket(SERVER_ADDRESS, SERVER_PORT);
             BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
             PrintWriter out = new PrintWriter(socket.getOutputStream(), true)) {

            Scanner scanner = new Scanner(System.in);
            while (true) {
                System.out.println("Choose an action: register, viewChallenges, attemptChallenge, viewApplicants, confirm, or exit:");
                String action = scanner.nextLine();
                if (action.equalsIgnoreCase("exit")) {
                    break;
                }

                out.println(action);

                switch (action.toLowerCase()) {
                    case "register":
                        registerParticipant(scanner, out, in);
                        break;
                    case "viewchallenges":
                        viewChallenges(in);
                        break;
                    case "attemptchallenge":
                        attemptChallenge(scanner, out, in);
                        break;
                    case "viewapplicants":
                        viewApplicants(in);
                        break;
                    case "confirm":
                        confirmApplicant(scanner, out, in);
                        break;
                    default:
                        System.out.println("Invalid action.");
                        break;
                }
            }
        } catch (IOException e) {
            System.err.println("Couldn't get I/O for the connection to " + SERVER_ADDRESS);
            System.exit(1);
        }
    }

    private static void registerParticipant(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        System.out.println("Enter registration details (username, firstname, lastname, emailAddress, dateOfBirth, schoolRegistrationNumber, imageFile) separated by commas:");
        String input = scanner.nextLine();
        out.println(input);

        System.out.println("Server response: " + in.readLine());
    }

    private static void viewChallenges(BufferedReader in) throws IOException {
        String response;
        while (!(response = in.readLine()).equals("---")) {
            System.out.println(response);
        }
    }

    private static void attemptChallenge(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        System.out.println("Enter the challenge number to attempt:");
        String challengeNumber = scanner.nextLine();
        out.println(challengeNumber);

        String response;
        while (!(response = in.readLine()).equals("Challenge completed.")) {
            System.out.println(response);
            if (response.startsWith("Question")) {
                System.out.println("Enter your answer:");
                String answer = scanner.nextLine();
                out.println(answer);
            }
        }
        System.out.println("Server response: " + response);
    }

    private static void viewApplicants(BufferedReader in) throws IOException {
        String response;
        while (!(response = in.readLine()).equals("---")) {
            System.out.println(response);
        }
    }

    private static void confirmApplicant(Scanner scanner, PrintWriter out, BufferedReader in) throws IOException {
        System.out.println("Enter confirmation details (yes/no username schoolNumber):");
        String input = scanner.nextLine();
        out.println(input);

        System.out.println("Server response: " + in.readLine());
    }
}
