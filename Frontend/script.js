const signup = document.querySelector('.signup');
const login = document.querySelector('.login');
const update = document.querySelector('.update ');
const logout = document.querySelector('.logout');
const delt = document.querySelector('.delete');

signup.addEventListener('click', () => {location.href= "./signup.html"})
login.addEventListener('click', () => {location.href= "./login.html"})
update.addEventListener('click', () => {location.href= "./update.html"})

logout.addEventListener('click', ()=> {
    fetch('http://localhost:3306/Model.php', {
        credentials: "include",
        method: "POST"
    })
    .then(res => res.text())
    .then(data=> {
        alert(data)
        location.href = "./index.html"
    })
    .catch(err => alert(err))
})
delt.addEventListener('click', ()=>{
    fetch('http://localhost:3306/Model.php', {
        credentials: "include",
        method: "DELETE"
    })
    .then(res => res.text())
    .then(data=> {
        alert(data)
        location.href = "./index.html"
    })
    .catch(err => alert(err))
})