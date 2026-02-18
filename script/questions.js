
const addQDialog = document.querySelector(".addNewQ");
const openQuestionF = document.querySelector(".addQ_btn");
const closeQuestionF = document.querySelector(".closeQ");

//opens the dialog element for adding new question
openQuestionF.addEventListener("click", () => {
  addQDialog.showModal();
})

//closes the dialog element for adding new question
closeQuestionF.addEventListener("click", () => {
  addQDialog.close();
})

//open the edit dialog form
const openEditForms = document.querySelectorAll(".openEditF");
openEditForms.forEach((form) => {
  form.addEventListener("click", () => {
    const id = form.dataset.editId;
    const editDialog = document.querySelector(`.edit${id}`);
    editDialog.showModal();
  });
});

//closes the edit dialog form
const closeEditForms = document.querySelectorAll(".closeEditF");
closeEditForms.forEach((form) => {
  form.addEventListener("click", () => {
    const id = form.dataset.editId;
    const editDialog = document.querySelector(`.edit${id}`);
    editDialog.close();
  });
});

//opens the delete dialog form
const openDeleteForms = document.querySelectorAll(".openDeleteF");
openDeleteForms.forEach((form) => {
  form.addEventListener("click", () => {
    const id = form.dataset.deleteId;
    const editDialog = document.querySelector(`.delete${id}`);
    editDialog.showModal();
  });
});

//closes the delete dialog form
const closeDeleteForms = document.querySelectorAll(".closeDeleteF");
closeDeleteForms.forEach((form) => {
  form.addEventListener("click", () => {
    const id = form.dataset.deleteId;
    const editDialog = document.querySelector(`.delete${id}`);
    editDialog.close();
  });
});
