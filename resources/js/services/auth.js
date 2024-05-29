import http from "@/services/http.js";

function logout() {
    http.get('auth/logout');
    localStorage.removeItem('APP_DEMO_USER_TOKEN');
    localStorage.removeItem('AUTH_USER');
    window.location.reload();
}
async function login(form) {
    try{
        await axios.get('/sanctum/csrf-cookie');
        const result = await http.post('/auth/login', form)

        if (result.status === 200 && result.data && result.data.token) {
            localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token);
            const response = await http.get('user');
            localStorage.setItem('AUTH_USER', JSON.stringify(response.data));

        }
    }catch(e){
        throw e;
    }
}
function getLocalAuthUser() {
    return JSON.parse((localStorage.getItem('AUTH_USER')));
}
export {logout, getLocalAuthUser, login}
