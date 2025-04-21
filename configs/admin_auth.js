
const token = localStorage.getItem('authToken');
const role = localStorage.getItem('role');
if (!token || role !== 'admin') {
    alert("Admin access only.");
    window.location.href = "login.php";
}

  