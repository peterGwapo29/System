<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("history page okay") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<!-- 

//let table = new DataTable("#myTable");

//ColumnDefs - Takes the value that affects the width of the headers in the tables
//           - Also your customize settings for each header

//data - column of the table where we get our data
//name - used for sorting purposes
//title - header of the column

const updateModal = document.getElementById("update");
const addBtn = document.getElementById("add-user");
const addNewModal = document.getElementById("modal");
const closeAddModal = document.querySelectorAll("#quit");
const addNewBtn = document.getElementById("add");
const loader = document.getElementById("loader");

console.log(loader);

function baseUrl() {
    //Equivalent to since we are in localhost : http://127.0.0.1:8000/
    return location.protocol + "//" + location.host + "";
}

let accountsTable = new DataTable("#myTable", {
    //our route where we request our data's

    ajax: baseUrl() + "/table/list",
    processing: true,
    serverSide: true,
    columnDefs: [{ targets: "_all", visible: true }],
    stateSave: true,

    columns: [
        {
            data: "account_id",
            name: "account_id",
            title: "Account ID",
        },
        {
            data: "account_number",
            name: "account_number",
            title: "Account Number",
        },
        {
            data: "account_type",
            name: "account_type",
            title: "Account Type",
        },
        {
            data: "balance",
            name: "balance",
            title: "Balance",
        },
        {
            data: "opened_date",
            name: "opened_date",
            title: "Opened Date",
        },
        {
            data: "status",
            title: "Status",
        },
        {
            data: "customer_id",
            name: "customer_id",
            title: "Customer ID",
        },
        {
            title: "Actions",
            data: "account_id",
            render: function (data) {
                return `
                <div class="flex justify-center gap-10 p-2 items-center w-full" style="gap:15px;">
                <img class="edit-btn cursor-pointer h-20"  name="Edit"   data-id="${data}" id="edit"  title="Edit Details" src="../../images/edit-user.png" style="height:40px;"> 
                <img class="cursor-pointer h-20"  name="Delete" id="delete" data-delete="${data}" title="Delete User" src="../../images/delete-user.png" style="height:40px;">


                </div>`;
            },
        },
    ],
});

document.getElementById("myTable").addEventListener("click", (e) => {
    const update_id = e.target.dataset.id;
    const delete_id = e.target.dataset.delete;
    if (e.target.id === "edit") {
        handleFormValue(update_id);
    } else if (e.target.id === "delete") {
        const token = document.querySelector('input[name="_token"').value;
        showDeleteModal(delete_id, token);
    }
});
closeAddModal.forEach((btn) => {
    btn.addEventListener("click", () => {
        updateModal.style.top = "-900px";
        addNewModal.style.top = "-900px";
    });
});
addBtn.addEventListener("click", () => {
    Swal.fire({
        title: "Confirm?",
        text: "You won't be able to revert this!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Add user",
    }).then((result) => {
        if (result.isConfirmed) {
            sendAddRequest();
        }
    });
});
addNewBtn.addEventListener("click", () => {
    showAddModal();
});

function handleFormValue(id) {
    showLoader();3
    fetch(user/${id})
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            closeLoader();
            showModal();
            //Sets the value of the form from the data queried in the db
            document.getElementById("id").value = data[0].account_id;
            document.getElementById("number").value = Number(
                data[0].account_number
            );
            document.getElementById("plan").value = data[0].account_type;
            document.getElementById("status").value = data[0].status;
            document.getElementById("balance").value = Number(data[0].balance);
            document.getElementById("date").value = data[0].opened_date;
            document.getElementById("customer").value = Number(
                data[0].customer_id
            );
        });
}

document.querySelectorAll("#update-user").forEach((btn) => {
    btn.addEventListener("click", () => {
        showConfirmation();
    });
});

function showConfirmation() {
    Swal.fire({
        title: "Confirm?",
        text: "You won't be able to revert this!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update user",
    }).then((result) => {
        if (result.isConfirmed) {
            //Gets the current form value
            const accId = document.getElementById("id").value;
            const accNum = document.getElementById("number").value;
            const balance = document.getElementById("balance").value;
            const opDate = document.getElementById("date").value;
            const customer = document.getElementById("customer").value;
            const plan = document.getElementById("plan").value;
            const status = document.getElementById("status").value;
            const token = document.querySelector('input[name="_token"').value;

            //Payload to be passed in laravel
            const payload = {
                id: Number(accId),
                number: Number(accNum),
                plan: plan,
                balance: Number(balance),
                date: opDate,
                status: status,
                customer_id: Number(customer),
            };

            sendUpdateRequest(payload, token, accId);
        }
    });
}

async function sendUpdateRequest(payload, token, accId) {
    try {
        //AJAX patch operation
        const request = await fetch(user/${accId}, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });

        if (request.ok) {
            // base route :  "http://127.0.0.1:8000/user";
            let timerInterval;
            Swal.fire({
                title: "User updated!",
                html: "<h1>Please wait shortly</h1>",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = ${Swal.getTimerLeft()};
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (
                    result.dismiss === Swal.DismissReason.timer ||
                    result.dismiss === Swal.DismissReason.backdrop ||
                    result.dismiss === Swal.DismissReason.cancel ||
                    result.dismiss === Swal.DismissReason.close ||
                    result.dismiss === Swal.DismissReason.esc
                ) {
                    accountsTable.ajax.reload();
                    closeModal();
                }
            });
        }
    } catch (error) {
        console.log(error.data);
    }
}

function showDeleteModal(id, token) {
    Swal.fire({
        title: "Wanna delete account?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirm",
    }).then((result) => {
        if (result.isConfirmed) {
            sendDeleteRequest(id, token);
        }
    });
}

async function sendDeleteRequest(id, token) {
    const request = await fetch(user/${id}, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    });

    if (request.ok) {
        console.log("request ok");
        Swal.fire({
            title: "Deletion Successfull!",
            html: "<h1>Please wait shortly</h1>",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = ${Swal.getTimerLeft()};
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (
                result.dismiss === Swal.DismissReason.timer ||
                result.dismiss === Swal.DismissReason.backdrop ||
                result.dismiss === Swal.DismissReason.cancel ||
                result.dismiss === Swal.DismissReason.close ||
                result.dismiss === Swal.DismissReason.esc
            ) {
                accountsTable.ajax.reload();
            }
        });
    } else {
        if (!request.ok) {
            const { message } = await request.json();
            Swal.fire({
                title: "Unsuccessfull",
                text: message,
                icon: "error",
            });
        }
    }
}

async function sendAddRequest() {
    const balance = document.getElementById("initial-balance").value;
    const customer = document.getElementById("customer-id").value;
    const plan = document.getElementById("acc-plans").value;
    const token = document.querySelector('input[name="_token"').value;

    const payload = {
        account_type: plan,
        balance: balance,
        customer_id: customer,
    };

    try {
        const request = await fetch("user/store", {
            method: "POST",
            headers: {
                "CONTENT-TYPE": "application/json",
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            body: JSON.stringify(payload),
        });

        if (!request.ok) {
            const { message } = await request.json();
            Swal.fire({
                title: "Unsuccessfull",
                text: message,
                icon: "error",
            });
        }

        if (request.ok) {
            Swal.fire({
                title: "User has been added Successfully!",
                html: "<h1>Please wait shortly</h1>",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = ${Swal.getTimerLeft()};
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (
                    result.dismiss === Swal.DismissReason.timer ||
                    result.dismiss === Swal.DismissReason.backdrop ||
                    result.dismiss === Swal.DismissReason.cancel ||
                    result.dismiss === Swal.DismissReason.close ||
                    result.dismiss === Swal.DismissReason.esc
                ) {
                    document.getElementById("initial-balance").value = "0";
                    document.getElementById("customer-id").value = "";
                    document.getElementById("acc-plans").value = "Savings";

                    accountsTable.ajax.reload();
                }
            });
        }
    } catch (error) {
        console.log("Error");
    }
}

function showModal() {
    updateModal.style.top = "0px";
}
function showAddModal() {
    addNewModal.style.top = "0px";
}

function closeModal() {
    updateModal.style.top = "-900px";
    addNewModal.style.top = "-900px";
}
function showLoader() {
    loader.classList.remove("invisible");
}

function closeLoader() {
    loader.classList.add("invisible");
} -->