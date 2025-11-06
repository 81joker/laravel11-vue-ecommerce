export const API_BASE_URL =  'http://localhost:8000/api';   
// export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';


export const headersConfig = (token = null, contentType = 'application/json') => {

  const headers = {
    "Content-Type": contentType,
    // Accept: 'application/json',
  };

  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  return { headers };
}
// const headersConfig = {
//   'Content-Type': 'application/json',
//   Accept: 'application/json',
// }

// export const getAuthHeaders = (token) => {
//   return {
//     ...headersConfig, 
//     Authorization: `Bearer ${token}`,
//   }
// }





//create a unique ref for each product
export const makeUniqueId = (length) => {
  let result = ''
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
  const charactersLength = characters.length
  let counter = 0
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength))
    counter += 1
  }
  return result
}