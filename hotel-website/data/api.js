// import { rooms, getRoomById } from "@/data/rooms";

import { foods, getFoodById } from "@/data/foods";

export const API_URL = process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000";

/**
 * Fetch all rooms from the API (with fallback).
 */
export async function fetchRooms() {

  const rooms='';

  try {
    const res = await fetch(`${API_URL}/api/rooms`, { cache: "no-store" });
    if (res.ok) {
      const data = await res.json();

      if (Array.isArray(data) && data.length > 0) return data;

    }

    // console.warn("Failed to fetch rooms:", data);

  } catch (error) {
    // Silent fallback to avoid HMR error log loop
  }
  return rooms;
}

/**
 * Fetch a single room by its ID (with fallback).
 */
export async function fetchRoomById(id) {
  
  try {
    const res = await fetch(`${API_URL}/api/rooms/${id}`, { cache: "no-store" });
    if (res.ok) {
      const data = await res.json();

      if (data && data.id) return data;
    }
  } catch (error) {
    // Silent fallback to avoid HMR error log loop
  }
  return getRoomById(id) || rooms.find(r => String(r.id) === String(id)) || null;
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
 * Fetch all food menu items from the API (with fallback).
 */
export async function fetchFoods() {
  try {
    const res = await fetch(`${API_URL}/api/foods`, { cache: "no-store" });
    if (res.ok) {
      const data = await res.json();
      if (Array.isArray(data) && data.length > 0) return data;
    }
  } catch (error) {
    // Silent fallback to avoid HMR error log loop
  }
  return foods;
}

/**
 * Fetch a single food item by its ID (with fallback).
 */
export async function fetchFoodById(id) {
  try {
    const res = await fetch(`${API_URL}/api/foods/${id}`, { cache: "no-store" });
    if (res.ok) {
      const data = await res.json();
      if (data && data.id) return data;
    }
  } catch (error) {
    // Silent fallback to avoid HMR error log loop
  }
  return getFoodById(id) || foods.find(f => String(f.id) === String(id)) || null;
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
