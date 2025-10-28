/**
 * Mock Tickets - ENTFERNT FÜR PRODUKTION
 *
 * Diese Datei wird später durch echte API-Calls ersetzt.
 * Die Struktur eines Tickets sollte folgende Felder enthalten:
 *
 * {
 *   id: number,
 *   title: string,
 *   category: 'music' | 'sports' | 'theater' | 'conference',
 *   date: string (YYYY-MM-DD),
 *   time: string (HH:MM),
 *   location: string,
 *   price: number,
 *   image: string (URL),
 *   description: string,
 *   available: number,
 *   rating: number,
 *   reviews: number,
 * }
 */

export const mockTickets = []

export const getTicketById = (id) => {
  return mockTickets.find(ticket => ticket.id === parseInt(id))
}

export const getRelatedTickets = (ticketId, limit = 3) => {
  const ticket = getTicketById(ticketId)
  if (!ticket) return []
  
  return mockTickets
    .filter(t => t.category === ticket.category && t.id !== ticketId)
    .slice(0, limit)
}

