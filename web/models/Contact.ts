export interface ContactInterface {
  id?: number;
  team_id?: number;
  name?: string;
  phone?: string;
  email?: string;
  sticky_phone_number_id?: number;
  created_at?: string;
  updated_at?: string;
}

export class Contact implements ContactInterface {
  id?: number;
  team_id?: number;
  name?: string;
  phone?: string;
  email?: string;
  sticky_phone_number_id?: number;
  created_at?: string;
  updated_at?: string;

  constructor({
    id,
    team_id,
    name,
    phone,
    email,
    sticky_phone_number_id,
    created_at,
    updated_at
  }: ContactInterface = {}) {
    this.id = id;
    this.team_id = team_id;
    this.name = name;
    this.phone = phone;
    this.email = email;
    this.sticky_phone_number_id = sticky_phone_number_id;
    this.created_at = created_at;
    this.updated_at = updated_at;
  }
}
