document.addEventListener('DOMContentLoaded', function () {
    // Heading and paragraph text
    const headingText = "Welcome To Elite Edge Gym<br>";
    const paragraphText = "Now you can easily check-in with just a few clicks.<br><br> Ready to mark your attendance?<br><br> Let's get started!";

    // Split the text into words
    const headingWords = headingText.split(' ');
    const paragraphWords = paragraphText.split(' ');

    // Function to display words one by one
    function typeWords(elementId, words, delay = 300) {
        const element = document.getElementById(elementId);
        let index = 0;

        function printNextWord() {
            if (index < words.length) {
                element.innerHTML += words[index] + " "; // Print each word
                index++;
                setTimeout(printNextWord, delay); // Delay between words
            }
        }

        printNextWord();
    }

    // Type heading and paragraph
    typeWords('dynamic-heading', headingWords, 500);  // Heading speed
    setTimeout(() => {
        typeWords('dynamic-paragraph', paragraphWords, 200);  // Paragraph speed after heading
    }, headingWords.length * 400);  // Wait for heading to finish typing
});