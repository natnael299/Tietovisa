
const teacher = document.getElementById("teacher");
const subject = document.getElementById("subject");
teacher.addEventListener("change", () => {
  subject.disabled = true;
  //clears the previous option elements
  subject.innerHTML = "";
  const teacherId = teacher.value;
  if (teacherId != "") {
    fetch(`get_subject.php?id=${teacherId}`)
      .then((res) => {
        subject.disabled = false;
        return res.json();
      })
      .then((data) => {
        subject.innerHTML = `<option>--- Valitse aihealue ---</option>`;
        //populate the select grid for subject
        data.forEach((row) => {
          const optionEle = document.createElement("option");
          optionEle.textContent = row.name;
          optionEle.value = row.id;
          subject.appendChild(optionEle);
        })
      })
      .catch((err) => console.log(err))
  } else {
    subject.innerHTML = `<option>Valitse opettaja ensin</option>`;
  }
})