export const API_URL = process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000";

/**
 * Fetch all rooms from the API.
 */
export async function fetchRooms() {
  try {
    const res = await fetch(`${API_URL}/api/rooms`, { cache: "no-store" });
    if (!res.ok) throw new Error("Failed to fetch rooms");
    return await res.json();
  } catch (error) {
    console.error(error);
    return [];
  }
}

/**
 * Fetch a single room by its ID.
 */
export async function fetchRoomById(id) {
  try {
    const res = await fetch(`${API_URL}/api/rooms/${id}`, { cache: "no-store" });
    if (!res.ok) throw new Error("Failed to fetch room detail");
    return await res.json();
  } catch (error) {
    console.error(error);
    return null;
  }
}

/**
 * Create a new booking in the backend.
 */
export async function createBooking(bookingData) {
  const res = await fetch(`${API_URL}/api/bookings`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(bookingData),
  });
  return await res.json();
}

/**
 * Fetch all food menu items from the API.
 */
export async function fetchFoods() {
  try {
    const res = await fetch(`${API_URL}/api/foods`, { cache: "no-store" });
    if (!res.ok) throw new Error("Failed to fetch foods menu");
    return await res.json();
  } catch (error) {
    console.error(error);
    return [];
  }
}

/**
 * Fetch a single food item by its ID.
 */
export async function fetchFoodById(id) {
  try {
    const res = await fetch(`${API_URL}/api/foods/${id}`, { cache: "no-store" });
    if (!res.ok) throw new Error("Failed to fetch food detail");
    return await res.json();
  } catch (error) {
    console.error(error);
    return null;
  }
}

/**
 * Create a new food order in the backend.
 */
export async function createOrder(orderData) {
  const res = await fetch(`${API_URL}/api/orders`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(orderData),
  });
  return await res.json();
}
