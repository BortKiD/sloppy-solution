// Отсутствует валидация ввода для кириллических букв и запятой
// Отсутствует возможность сортировки таблицы

document.addEventListener("DOMContentLoaded", function() {
    let tableIndex = 1;
    const inputField = document.getElementById("participants");

    document.getElementById("addButton").addEventListener("click", handleEntry);
  
    inputField.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        handleEntry()
      }
    });

    function isValidCyrillicInput(value) {
      var validationRegex = RegExp("[\wа-я]+,?");
      var testResult = validationRegex.test(value);
      return testResult;
    }

    // Обработка ввода с поля
    function handleEntry() {
      if (inputField.value === "") {
        return;
      }

      const participantNames = inputField.value.split(",");
      namesLength = participantNames.length;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onload = function() {
        response = this.response;
        const participantPoints = response.split(",");
        displayParticipants(participantNames, participantPoints)
      };
      xmlhttp.open("GET", "generatePoints.php?len=" + namesLength, true);
      xmlhttp.send();
    }

    // Отображение участников в таблице
    function displayParticipants(names, points) {
      const tableBody = document.getElementById("participantsTableBody");
  
      var participants = names.map(function(e, i) {
        return [e, points[i]];
      });

      participants.forEach((participant, index) => {
        if (participant[0] !== "") {
          const row = tableBody.insertRow();
          const idCell = row.insertCell(0);
          const nameCell = row.insertCell(1);
          const pointsCell = row.insertCell(2);
    
          idCell.textContent = tableIndex;
          nameCell.textContent = participant[0];
          pointsCell.textContent = participant[1];
          tableIndex++;
        }
      });
  
      document.getElementById("participants").value = "";
      document.getElementById("tableContainer").style.display = "block";
    }

  });