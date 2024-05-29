import http from "@/services/http.js";

function logout() {
    http.get('auth/logout');
    localStorage.removeItem('APP_DEMO_USER_TOKEN');
    localStorage.removeItem('AUTH_USER');
    window.location.reload();
}
function login() {

}
export {logout, login}
