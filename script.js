const table = document.getElementById("studentTable");
const form = document.getElementById("studentForm");
const message = document.getElementById("message");

function escapeHTML(value) {
    return String(value).replace(/[&<>"']/g, function(char) {
        return {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;"
        }[char];
    });
}

// Display all student records

function loadStudents() {

    fetch("php/fetch.php")
    .then(response => response.json())
    .then(data => displayStudents(data));

}

// Display records in HTML table

function displayStudents(data) {

    table.innerHTML = "";

    data.forEach(student => {

        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${escapeHTML(student.roll_no)}</td>
            <td>${escapeHTML(student.name)}</td>
            <td>${escapeHTML(student.gender)}</td>
            <td>${escapeHTML(student.department)}</td>
            <td>${escapeHTML(student.marks)}</td>
            <td>
                <button onclick="editStudent('${escapeHTML(student.roll_no)}')">Edit</button>
                <button onclick="deleteStudent('${escapeHTML(student.roll_no)}')">Delete</button>
            </td>
        `;

        table.appendChild(row);

    });

}

// Insert new student using AJAX

form.addEventListener("submit", function(e) {

    e.preventDefault();

    const formData = new FormData(form);

    fetch("php/insert.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {

        message.textContent = data;

        if (data.includes("successfully")) {
            form.reset();
            loadStudents();
            loadStats();
        }

    });

});

// Live search

document.getElementById("search")
.addEventListener("input", function() {

    const value = this.value;

    fetch("php/search.php?search=" + encodeURIComponent(value))
    .then(response => response.json())
    .then(data => displayStudents(data));

});

// Calculate statistics

function loadStats() {

    fetch("php/stats.php")
    .then(response => response.json())
    .then(data => {

        let html = `
            <p>Total Marks: ${data.total}</p>
            <p>Average Marks: ${data.average}</p>
        `;

        data.students.forEach(student => {

            html += `
                <p>
                    ${escapeHTML(student.name)} -
                    Marks: ${escapeHTML(student.marks)} -
                    Grade: ${escapeHTML(student.grade)}
                </p>
            `;

        });

        document.getElementById("statistics").innerHTML = html;

    });

}

// Delete student

function deleteStudent(roll) {

    if (!confirm("Delete this student?")) return;

    fetch("php/delete.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "roll_no=" + encodeURIComponent(roll)
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadStudents();
        loadStats();
    });

}

// Edit student

function editStudent(roll) {

    const name = prompt("Enter new student name:");

    if (name === null || name.trim() === "") return;

    const marks = prompt("Enter new marks:");

    if (marks === null || marks.trim() === "") return;

    fetch("php/update.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({
            roll_no: roll,
            name: name,
            marks: marks
        })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadStudents();
        loadStats();
    });

}

// Sort table

let sortColumn = "";
let sortOrder = "ASC";

document.querySelectorAll("th[data-sort]").forEach(header => {

    header.addEventListener("click", function() {

        const column = this.dataset.sort;

        if (sortColumn === column) {
            sortOrder = sortOrder === "ASC" ? "DESC" : "ASC";
        } else {
            sortColumn = column;
            sortOrder = "ASC";
        }

        fetch("php/sort.php?column=" + encodeURIComponent(column)
            + "&order=" + sortOrder)
        .then(response => response.json())
        .then(data => displayStudents(data));

    });

});

// Initial loading

loadStudents();
loadStats();